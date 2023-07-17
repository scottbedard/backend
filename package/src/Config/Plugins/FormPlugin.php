<?php

namespace Bedard\Backend\Config\Plugins;

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
        ];
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
        $path = str(
            str($request->extra)
                ->lower()
                ->explode('/')
                ->map(fn ($seg) => trim($seg))
                ->implode('/')
        );

        $context = 'create';

        $id = null;

        $model = null;

        if ($path->is('edit/*')) {
            $context = 'edit';

            $id = str($path)->match('/edit\/(.*)/');
        }

        if ($id) {
            $model = $this->model::where($this->key, $id)->firstOrFail();
        }

        return view('backend::form', [
            'actions' => $this->actions,
            'fields' => $this->fields,
            'model' => $model,
        ]);
    }
}
