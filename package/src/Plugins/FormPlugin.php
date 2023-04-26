<?php

namespace Bedard\Backend\Plugins;

use Bedard\Backend\Classes\Breakpoint;
use Bedard\Backend\Classes\KeyedArray;
use Bedard\Backend\Classes\Paginator;
use Bedard\Backend\Facades\Backend;
use Bedard\Backend\Form\TextField;
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
        'options.fields.*.type' => ['present', 'nullable', 'string'],
    ];

    /**
     * Fields
     *
     * @return array
     */
    public function fields(): array
    {
        $aliases = config('backend.fields', []);

        return array_map(function ($field) use ($aliases) {
            $type = data_get($field, 'type', 'text');

            if (array_key_exists($type, $aliases)) {
                $type = $aliases[$type];
            }

            if (!class_exists($type)) {
                throw new Exception("Field type \"{$type}\" not found");
            }

            return new $type($field);
        }, $this->option('fields'));
    }

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

        // fill field data
        $aliases = config('backend.fields', []);

        foreach ($this->route['options']['fields'] as $key => $field) {
            data_fill($this->route, "options.fields.{$key}.disabled", false);
            data_fill($this->route, "options.fields.{$key}.label", str($field['id'])->headline()->toString());
            data_fill($this->route, "options.fields.{$key}.order", 0);
            data_fill($this->route, "options.fields.{$key}.type", TextField::class);

            // set breakpoints
            data_set($this->route, "options.fields.{$key}.span", Breakpoint::create($field['span'] ?? 12));

            // apply field aliases
            if (data_get($field, 'type') === null) {
                data_set($this->route, "options.fields.{$key}.type", TextField::class);
            } elseif (array_key_exists($field['type'], $aliases)) {
                data_set($this->route, "options.fields.{$key}.type", $aliases[$field['type']]);
            } else {
                data_set($this->route, "options.fields.{$key}.type", $field['type']);
            }
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
            'fields' => $this->fields(),
            'options' => $this->options(),
        ]);
    }
}
