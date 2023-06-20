<?php

namespace Bedard\Backend\Config\Plugins;

use Bedard\Backend\Classes\Sort;
use Bedard\Backend\Classes\Paginator;
use Bedard\Backend\Config\Plugins\List\Column;
use Illuminate\Http\Request;
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
     */
    public function handle(Request $request)
    {
        // create query builder
        $query = $this->model::query();

        // sort the query if params are present
        $sort = Sort::create($request->fullUrl());
        
        if ($sort->column && $sort->direction !== 0) {
            $query->orderBy($sort->column, $sort->direction === 1 ? 'asc' : 'desc');
        }

        // paginate the results
        $paginator = Paginator::for($query);

        return view('backend::list', [
            'columns' => $this->columns,
            'paginator' => $paginator,
        ]);
    }
}
