<?php

namespace Bedard\Backend\Config\Plugins;

use Bedard\Backend\Config\Controller;
use Bedard\Backend\Config\Plugins\Form\Action;
use Bedard\Backend\Config\Plugins\Form\Field;
use Illuminate\Http\Request;

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

        // save or create a model
        if ($request->method() === 'POST') {
            $data = $request->all();

            foreach ($data['model'] as $key => $value) {
                $model->{$key} = $value;
            }

            if ($id) {
                $model->save();
            } else {
                $model->create();
            }
        }

        // delete a model
        else if ($request->method() === 'DELETE') {
            throw new \Exception('Not implemented');
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
}
