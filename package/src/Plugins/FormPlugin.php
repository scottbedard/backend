<?php

namespace Bedard\Backend\Plugins;

use Bedard\Backend\Classes\Paginator;
use Bedard\Backend\Facades\Backend;
use Bedard\Backend\Plugin;
use Exception;
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
        'options.fields.*.disabled' => ['present', 'boolean'],
        'options.fields.*.label' => ['present', 'nullable', 'string'],
        'options.fields.*.order' => ['present', 'integer'],
        'options.fields' => ['present', 'array'],
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
        data_set($this->route, 'options.fields', $this->sequential($this->option('fields')));

        // extend parent form
        $extends = $this->option('extends');

        if ($extends) {
            $parent = data_get($this->controller, "routes.{$extends}.options.fields");

            if (!$parent) {
                throw new Exception("Failed to extend form {$extends}");
            }

            $fields = collect($this->option('fields'));

            $extensions = collect($this->sequential($parent))->map(function ($field) use ($fields) {
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
        }

        // finalize normalization and order fields
        $this->route['options']['fields'] = collect($this->route['options']['fields'])
            ->sortBy('order')
            ->values()
            ->toArray();
    }

    /**
     * Normalize fields to a sequential array
     *
     * @param array $fields
     */
    private function sequential(array $fields): array
    {
        $arr = [];

        // normalize fields to a sequential array
        if (Arr::isAssoc($fields)) {
            foreach ($fields as $id => $field) {
                $arr[] = array_merge(['id' => $id], $field ?? []);
            }
        } else {
            $arr = $fields;
        }

        // prevent blank fields from being treated as null
        foreach ($arr as $i => $field) {
            if ($field === null) $arr[$i] = [];
        }

        return $arr;
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
