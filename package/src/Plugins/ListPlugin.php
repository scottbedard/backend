<?php

namespace Bedard\Backend\Plugins;

use Bedard\Backend\Classes\Href;
use Bedard\Backend\Classes\KeyedArray;
use Bedard\Backend\Classes\Paginator;
use Bedard\Backend\Facades\Backend;
use Bedard\Backend\Plugin;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ListPlugin extends Plugin
{
    /**
     * Validation rules
     *
     * @var array
     */
    protected array $rules = [
        // actions
        'options.actions' => ['present', 'array'],
        'options.actions.*.icon' => ['string'],
        'options.actions.*.label' => ['required', 'string'],
        'options.actions.*.to' => ['string'],

        // checkboxes
        'options.checkboxes' => ['required', 'boolean'],

        // schema
        'options.schema' => ['present', 'array'],
        'options.schema.*.type' => ['required', 'string'],
    ];

    /**
     * Normalize plugin config
     *
     * @return void
     */
    public function normalize(): void
    {
        if (data_get($this->route, 'options') === null) {
            data_set($this->route, 'options', []);
        }

        data_fill($this->route, 'options.actions', []);
        data_fill($this->route, 'options.checkboxes', false);
        data_fill($this->route, 'options.row_to', null);
        data_fill($this->route, 'options.schema', []);

        data_set($this->route, 'options.schema', KeyedArray::of($this->route['options']['schema'], 'id'));

        if ($this->route['options']['row_to']) {
            $this->route['options']['row_to'] = Href::format($this->route['options']['row_to'], $this->controller['path']);
        }

        foreach ($this->route['options']['actions'] as $key => $action) {
            data_fill($this->route, "options.actions.{$key}.theme", 'default');
        }

        foreach ($this->route['options']['schema'] as $key => $col) {
            data_fill($this->route, "options.schema.{$key}.type", 'text');
            data_fill($this->route, "options.schema.{$key}.label", Str::headline($col['id']));
        }
    }

    /**
     * Render the plugin
     *
     * @return \Illuminate\View\View
     */
    public function view(): View
    {
        $model = $this->route['model'];

        $query = $model::query();

        return view('backend::list', [
            'props' => [
                'data' => Paginator::for($query),
                'options' => $this->route['options'],
            ],
        ]);
    }
}
