<?php

namespace Bedard\Backend\Config\Plugins;

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
            'columns' => ['present', 'array'],
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
        $models = $this->model::query()
            ->orderBy('id', 'desc')
            ->paginate(10);
        
        return [
            'columns' => $this->columns,
            'models' => $models,
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
