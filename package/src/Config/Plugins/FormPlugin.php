<?php

namespace Bedard\Backend\Config\Plugins;

use Bedard\Backend\Config\Common\Action;
use Bedard\Backend\Config\Controller;
use Bedard\Backend\Config\Plugins\Form\Field;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormPlugin extends Plugin
{
    /**
     * Define child config
     *
     * @return array
     */
    public function defineChildren(): array
    {
        return [
            'actions' => [Action::class],
            'fields' => [Field::class, 'id'],
        ];
    }

    /**
     * Define inherits
     *
     * @return array
     */
    public function defineInherits(): array
    {
        return [
            'model',
        ];
    }

    /**
     * Define validation rules
     *
     * @return array
     */
    public function defineValidation(): array
    {
        return [
            'actions' => ['present', 'array'],
            'fields' => ['present', 'array'],
            'key' => ['required', 'string'],
            'model_name' => ['present', 'nullable', 'string'],
        ];
    }

    /**
     * Get default config
     *
     * @return array
     */
    public function getDefaultConfig(): array
    {
        return [
            'actions' => [],
            'fields' => [],
            'key' => 'id',
            'model_name' => null,
        ];
    }

    /**
     * Get name attribute
     * 
     * @return string
     */
    public function getModelNameAttribute(): string
    {
        $name = data_get($this->__data, 'name');

        if ($name) {
            return $name;
        }

        return str(str($this->route()->plugin->model)->explode('\\')->last())->title();
    }

    /**
     * Validate form data
     *
     * @return array
     */
    public function getRulesAttribute(): array
    {
        if (array_key_exists('rules', $this->__data)) {
            return $this->__data['rules'];
        }

        $rules = [];
        
        foreach ($this->fields as $field) {
            $rules[$field->id] = $field->rules;
        }

        return $rules;
    }

    /**
     * Render
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\View\View|array
     */
    public function handle(Request $request)
    {
        // normalize the route path and param
        $path = str(
            str($request->extra)
                ->lower()
                ->explode('/')
                ->map(fn ($seg) => trim($seg))
                ->implode('/')
        );

        $id = $path->is('edit/*')
            ? $path->match('/edit\/(.*)/')
            : null;

        $model = $id
            ? $this->model::where($this->key, $id)->first()
            : null;

        // show form on get
        $method = $request->method();

        if ($method === 'GET') {
            return view('backend::form', [
                'actions' => $this->actions,
                'fields' => $this->fields,
                'model' => $model,
            ]);
        }

        // handle actions
        if ($request->method() === 'POST') {
            $data = $request->all();
            $action = data_get($data, 'action');

            if ($action === 'delete') {
                return $this->handleDelete(
                    id: $id,
                    model: $model,
                    request: $request,
                );
            }

            return $this->handleCreateOrSave(
                data: $data,
                id: $id,
                model: $model,
                request: $request,
            );
        }

        return redirect()->back()->with('message', [
            'icon' => 'alert-triangle',
            'status' => 'error',
            'text' => 'Unknown form action',
        ]);
    }

    /**
     * Handle create or save
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Model|null  $model
     * @param  string|null  $id
     * @param  array  $data
     */
    public function handleCreateOrSave(Request $request, ?Model $model, ?string $id, array $data)
    {
        $validator = Validator::make($data['model'], $this->rules);
     
        if ($validator->fails()) {
            $errorKey = null;
            $errorMessage = null;

            foreach ($validator->errors()->getMessages() as $key => $message) {
                $errorKey = $key;
                $errorMessage = $message[0];
                break;
            }

            return redirect()->back()->with([
                'errors' => $validator->errors(),
                'message' => [
                    'icon' => 'alert-triangle',
                    'property' => $errorKey,
                    'status' => 'error',
                    'text' => $errorMessage,
                ],
                'model' => $data['model'],
            ]);
        }

        foreach ($data['model'] as $key => $value) {
            $model->{$key} = $value;
        }

        if ($id) {
            $model->save();
        } else {
            $model->create();
        }

        return to_route('backend.controller.route', [
            'controllerOrRoute' => $request->route()->controllerOrRoute,
            'extra' => $request->route()->extra,
            'route' => $request->route()->route,
        ])->with('message', [
            'icon' => 'check',
            'status' => 'success',
            'text' => $this->modelName . ' ' . $id . ' has been saved!',
        ]);
    }

    /**
     * Handle delete
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Model|null  $model
     * @param  string  $id
     */
    public function handleDelete(Request $request, ?Model $model, string $id)
    {
        if ($model) {
            $model->delete();
        }

        return to_route('backend.controller.route', [
            'controllerOrRoute' => $request->route()->controllerOrRoute,
            'route' => $request->route()->route,
        ])->with('message', [
            'icon' => 'check',
            'status' => 'success',
            'text' => $this->modelName . ' ' . $id . ' has been deleted!',
        ]);
    }
}
