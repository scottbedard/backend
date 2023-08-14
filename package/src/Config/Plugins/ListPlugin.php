<?php

namespace Bedard\Backend\Config\Plugins;

use Bedard\Backend\Classes\Sort;
use Bedard\Backend\Classes\To;
use Bedard\Backend\Config\Backend;
use Bedard\Backend\Config\Common\Action;
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
            'actions' => [Action::class],
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
            'actions' => ['present', 'array'],
            'checkboxes' => ['present', 'boolean'],
            'columns' => ['present', 'array'],
            'model' => ['required', 'string'],
            'plural' => ['present', 'nullable', 'string'],
            'row_to' => ['present', 'nullable', 'string'],
            'singular' => ['present', 'nullable', 'string'],
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
            'columns' => [],
            'plural' => null,
            'row_to' => null,
            'singular' => null,
        ];
    }

    /**
     * Plural
     *
     * @return string
     */
    public function getPluralAttribute(): ?string
    {
        $value = data_get($this->__data, 'plural');
        
        if (is_string($value)) {
            return $value;
        }

        return str($this->model)
            ->classBasename()
            ->headline()
            ->plural()
            ->toString();
    }

    /**
     * Singular
     *
     * @return string
     */
    public function getSingularAttribute(): ?string
    {
        $value = data_get($this->__data, 'singular');
        
        if (is_string($value)) {
            return $value;
        }

        return str($this->model)
            ->classBasename()
            ->headline()
            ->singular()
            ->toString();
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
            'actionData' => [
                'plural' => $this->plural,
                'singular' => $this->singular,
            ],
            'actions' => $this->actions,
            'checkboxes' => $this->checkboxes,
            'columns' => $this->columns,
            'config' => $this,
            'hrefs' => $hrefs,
            'paginator' => $paginator,
        ]);
    }
}
