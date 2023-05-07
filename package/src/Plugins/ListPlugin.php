<?php

namespace Bedard\Backend\Plugins;

use Bedard\Backend\Classes\Href;
use Bedard\Backend\Classes\Paginator;
use Bedard\Backend\Configuration\ListAction;
use Illuminate\View\View;

class ListPlugin extends Plugin
{
    /**
     * Default data
     *
     * @var array
     */
    public array $defaults = [
        'actions' => [],
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
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public array $rules = [
        'actions' => ['present', 'array'],
        'checkboxes' => ['present', 'boolean'],
        'model' => ['required', 'string'],

        // // actions
        // 'options.actions' => ['present', 'array'],
        // 'options.actions.*.icon' => ['string'],
        // 'options.actions.*.label' => ['required', 'string'],
        // 'options.actions.*.to' => ['string'],


        // // schema
        // 'options.schema' => ['present', 'array'],
        // 'options.schema.*.type' => ['required', 'string'],
    ];
    
    /**
     * Render a plugin.
     *
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        $model = $this->get('model');
        $query = $model::query();


        return view('backend::list', [
            'props' => [
                'data' => Paginator::for($query),
                'options' => $this->config,
            ],
        ]);
    }

    // /**
    //  * Normalize plugin config
    //  *
    //  * @return void
    //  */
    // public function normalize(): void
    // {
    //     if (data_get($this->route, 'options') === null) {
    //         data_set($this->route, 'options', []);
    //     }

    //     data_fill($this->route, 'options.actions', []);
    //     data_fill($this->route, 'options.checkboxes', false);
    //     data_fill($this->route, 'options.row_to', null);
    //     data_fill($this->route, 'options.schema', []);

    //     data_set($this->route, 'options.schema', KeyedArray::from($this->route['options']['schema'], 'id'));

    //     if ($this->route['options']['row_to']) {
    //         $this->route['options']['row_to'] = Href::format($this->route['options']['row_to'], $this->controller['path']);
    //     }

    //     foreach ($this->route['options']['actions'] as $key => $action) {
    //         data_fill($this->route, "options.actions.{$key}.theme", 'default');
    //     }

    //     foreach ($this->route['options']['schema'] as $key => $col) {
    //         data_fill($this->route, "options.schema.{$key}.type", 'text');
    //         data_fill($this->route, "options.schema.{$key}.label", Str::headline($col['id']));
    //     }
    // }

    // /**
    //  * Render the plugin
    //  *
    //  * @return \Illuminate\View\View
    //  */
    // public function view(): View
    // {
    //     $model = $this->route['model'];

    //     $query = $model::query();

    //     return view('backend::list', [
    //         'props' => [
    //             'data' => Paginator::for($query),
    //             'options' => $this->route['options'],
    //         ],
    //     ]);
    // }
}
