<?php

namespace Bedard\Backend\Plugins;

use Bedard\Backend\Classes\Href;
use Bedard\Backend\Classes\Paginator;
use Bedard\Backend\Configuration\ListAction;
use Bedard\Backend\Configuration\ListColumn;
use Illuminate\View\View;

class ListPlugin extends Plugin
{
    /**
     * Default data
     *
     * @var array
     */
    public array $defaults = [
        'checkboxes' => false,
    ];

    /**
     * Inherited data
     *
     * @var array
     */
    public array $inherits = [
        'model',
    ];

    /**
     * Child properties
     *
     * @var array
     */
    public array $props = [
        'actions' => [ListAction::class],
        'schema' => [ListColumn::class, 'id'],
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public array $rules = [
        'actions' => ['present', 'array'],
        'checkboxes' => ['present', 'boolean'],
        'schema' => ['present', 'array'],
    ];

    /**
     * Get normalized list options
     *
     * @return array
     */
    public function options()
    {
        $options = $this->toArray();

        $options['row_to'] = Href::format($options['row_to'], $this->controller()->path());

        return $options;
    }

    /**
     * Query list data
     *
     * @return array
     */
    public function query(): array
    {
        $model = $this->get('model');

        $query = $model::query();

        return Paginator::for($query);
    }
    
    /**
     * Render
     *
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('backend::list', [
            'props' => [
                'data' => $this->query(),
                'options' => $this->options(),
            ],
        ]);
    }
}
