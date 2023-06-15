<?php

namespace Bedard\Backend\Config\Plugins;

use Bedard\Backend\Classes\KeyedArray;
use Bedard\Backend\Classes\Paginator;
use Bedard\Backend\Config\Backend;
use Bedard\Backend\Config\Config;
use Bedard\Backend\Config\Plugins\List\Column;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ListPlugin extends Plugin
{
    /**
     * Define child config
     *
     * @return array
     */
    public function defineChildren(): array
    {
        return [
            'columns' => [Column::class, 'id'],
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
            'checkboxes' => ['present', 'boolean'],
            'columns' => ['present', 'array'],
            'model' => ['required', 'string'],
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
    public function handle(Request $request)
    {
        $models = $this->model::query();

        $paginator = Paginator::for($models);

        return view('backend::list', [
            'columns' => $this->columns,
            'paginator' => $paginator,
        ]);
    }
}
