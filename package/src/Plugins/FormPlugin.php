<?php

namespace Bedard\Backend\Plugins;

use Bedard\Backend\Classes\Breakpoint;
use Bedard\Backend\Classes\KeyedArray;
use Bedard\Backend\Classes\Paginator;
use Bedard\Backend\Facades\Backend;
use Bedard\Backend\Plugin;
use Exception;
use Illuminate\View\View;

class FormPlugin extends Plugin
{
    /**
     * Validation rules
     *
     * @var array
     */
    protected array $rules = [
        'options.fields' => ['present', 'array'],
        'options.fields.*.disabled' => ['present', 'boolean'],
        'options.fields.*.label' => ['present', 'nullable', 'string'],
        'options.fields.*.order' => ['present', 'integer'],
        'options.fields.*.placeholder' => ['string'],
        'options.fields.*.type' => ['present', 'string'],
    ];

    /**
     * Normalize plugin config
     *
     * @return void
     */
    public function normalize(): void
    {
        // prevent empty options from being treated as null
        if (data_get($this->route, 'options') === null) {
            data_set($this->route, 'options', []);
        }

        // fill default options
        data_fill($this->route, 'options.extends', null);
        data_fill($this->route, 'options.fields', []);

        // normalize fields
        data_set($this->route, 'options.fields', KeyedArray::of($this->option('fields'), 'id'));

        // extend parent form
        $extends = $this->option('extends');

        if ($extends) {
            $parent = data_get($this->controller, "routes.{$extends}.options.fields");

            if (!$parent) {
                throw new Exception("Failed to extend form {$extends}");
            }

            $fields = collect($this->option('fields'));

            $extensions = collect(KeyedArray::of($parent, 'id'))->map(function ($field) use ($fields) {
                $child = $fields->first(fn ($child) => $child['id'] === $field['id']);

                if ($child) {
                    $field = array_merge($field, $child);
                }

                return $field;
            });

            $this->route['options']['fields'] = $extensions
                ->concat($fields->filter(fn ($field) => !$extensions->contains('id', $field['id'])))
                ->toArray();
        }

        // fill default field data
        foreach ($this->route['options']['fields'] as $key => $field) {
            data_fill($this->route, "options.fields.{$key}.disabled", false);
            data_fill($this->route, "options.fields.{$key}.label", str($field['id'])->headline()->toString());
            data_fill($this->route, "options.fields.{$key}.order", 0);
            data_fill($this->route, "options.fields.{$key}.type", 'text');

            data_set($this->route, "options.fields.{$key}.span", Breakpoint::create($field['span'] ?? 12));
        }

        // finalize normalization and order fields
        $this->route['options']['fields'] = collect($this->route['options']['fields'])
            ->sortBy('order')
            ->values()
            ->toArray();
    }

    /**
     * Plugin view
     *
     * @return \Illuminate\View\View
     */
    public function view(): View
    {
        return view('backend::form', [
            'options' => $this->route['options'],
        ]);
    }
}
