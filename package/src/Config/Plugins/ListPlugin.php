<?php

namespace Bedard\Backend\Config\Plugins;

use Bedard\Backend\Classes\Sort;
use Bedard\Backend\Classes\To;
use Bedard\Backend\Config\Backend;
use Bedard\Backend\Config\Controller;
use Bedard\Backend\Config\Plugins\List\Column;
use Bedard\Backend\Config\Route;
use Illuminate\Http\Request;

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
            'row_to' => ['present', 'nullable', 'string'],
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
            'row_to' => null,
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

        // fetch paginated data
        $paginator = $query->paginate(20);

        $hrefs = $paginator
            ->map(fn ($row) => To::href(
                backend: $this->closest(Backend::class),
                controller: $this->closest(Controller::class)?->path ?? '',
                data: $row,
                route: $this->closest(Route::class)?->path ?? '',
                to: $this->row_to,
            ))
            ->toArray();

        return view('backend::list', [
            'columns' => $this->columns,
            'config' => $this,
            'hrefs' => $hrefs,
            'paginator' => $paginator,
        ]);
    }
}
