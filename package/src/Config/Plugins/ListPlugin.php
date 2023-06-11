<?php

namespace Bedard\Backend\Config\Plugins;

use Bedard\Backend\Classes\KeyedArray;
use Bedard\Backend\Classes\Paginator;
use Bedard\Backend\Config\Backend;
use Bedard\Backend\Config\Config;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ListPlugin extends Plugin
{
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
            'checkboxes' => ['present', 'boolean'],
            'columns' => ['present', 'array'],
            'columns.*.type' => ['in:blade,date,text,timeago'],
            'model' => ['required', 'string'],
        ];
    }

    /**
     * Props
     *
     * @return array
     */
    public function props(Request $request)
    {
        $models = $this->model::query();
        
        return [
            'data' => Paginator::for($models),
            'options' => [
                'checkboxes' => $this->checkboxes,
                'columns' => KeyedArray::from($this->columns, 'id'),
            ],
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
            'columns' => [],
        ];
    }

    /**
     * Render
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\View\View|array
     */
    public function handle(Request $request): View|array
    {
        return view('backend::list', [
            'props' => $this->props($request),
        ]);
    }
}
