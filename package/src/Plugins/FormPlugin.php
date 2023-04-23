<?php

namespace Bedard\Backend\Plugins;

use Bedard\Backend\Classes\Paginator;
use Bedard\Backend\Facades\Backend;
use Bedard\Backend\Plugin;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class FormPlugin extends Plugin
{
    /**
     * Validation rules
     *
     * @var array
     */
    protected array $rules = [
        // actions
        // 'options.fields' => ['present', 'array'],
        // 'options.fields.*.label' => ['present', 'nullable', 'string'],
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

        data_fill($this->route, 'options.fields', []);

        if (Arr::isAssoc($this->route['options']['fields'])) {
            $cols = [];

            foreach ($this->route['options']['fields'] as $id => $col) {
                $cols[] = array_merge(['id' => $id], $col ?? []);
            }

            data_set($this->route, 'options.fields', $cols);
        }
    }

    /**
     * Plugin view
     *
     * @return \Illuminate\View\View
     */
    public function view(): View
    {
        return view('backend::form', [
            'props' => [
                'options' => $this->route['options'],
            ],
        ]);
    }
}
