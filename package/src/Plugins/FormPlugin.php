<?php

namespace Bedard\Backend\Plugins;

use Bedard\Backend\Classes\ArrayUtil;
use Bedard\Backend\Configuration\Configuration;
use Bedard\Backend\Configuration\FormField;
use Bedard\Backend\Exceptions\ConfigurationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;

class FormPlugin extends Plugin
{
    /**
     * Default data
     *
     * @var array
     */
    public array $defaults = [
        'fields' => [],
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
        'fields' => [FormField::class, 'id'],
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public array $rules = [
        'fields' => ['present', 'array'],
        'model' => ['nullable', 'string'],
    ];

    /**
     * Construct
     *
     * @param array $config
     * @param ?\Bedard\Backend\Configuration\Configuration $parent
     */
    public function __construct(array $config = [], ?Configuration $parent = null)
    {
        parent::__construct($config, $parent);

        // extend parent form
        $extends = $this->get('extends');

        if ($extends) {
            $base = $this->controller()->route($extends)?->plugin();

            if (!$base) {
                throw new ConfigurationException("Failed to extend \"{$extends}\", form not found");
            }

            $this->data['fields'] = collect(ArrayUtil::mergeBy($base->get('fields'), $this->get('fields'), 'id'))
                ->map(function ($field) {
                    if (!array_key_exists('order', $field)) {
                        $field['order'] = 0;
                    }

                    return FormField::create($field, $this);
                })
                ->sortBy('order')
                ->values();
        }
    }

    /**
     * Form data
     *
     * @return ?\Illuminate\Database\Eloquent\Model
     */
    public function data(): ?Model
    {
        $model = $this->get('model');

        if (!$model) {
            return null;
        }

        return $model::where(request()->route()->parameters)->firstOrFail();
    }

    /**
     * Render
     *
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        $data = $this->data();

        return view('backend::form', [
            'data' => $data,
        ]);
    }

    // /**
    //  * Fields
    //  *
    //  * @return array
    //  */
    // public function fields(): array
    // {
    //     return array_map(function ($field) {
    //         if (!class_exists($field['type'])) {
    //             throw new Exception("Field type \"{$field['type']}\" not found");
    //         }

    //         return new $field['type']($field);
    //     }, $this->option('fields'));
    // }

    // /**
    //  * Normalize plugin config
    //  *
    //  * @return void
    //  */
    // public function normalize(): void
    // {
    //     // prevent empty options from being treated as null
    //     if (data_get($this->route, 'options') === null) {
    //         data_set($this->route, 'options', []);
    //     }

    //     // fill default options
    //     data_fill($this->route, 'options.actions', []);
    //     data_fill($this->route, 'options.extends', null);
    //     data_fill($this->route, 'options.fields', []);

    //     // normalize fields
    //     data_set($this->route, 'options.fields', KeyedArray::from($this->option('fields'), 'id'));

    //     // extend parent form
    //     $extends = $this->option('extends');

    //     if ($extends) {
    //         $parent = data_get($this->controller, "routes.{$extends}.options.fields");

    //         if (!$parent) {
    //             throw new Exception("Failed to extend form {$extends}");
    //         }

    //         $fields = collect($this->option('fields'));

    //         $extensions = collect(KeyedArray::from($parent, 'id'))->map(function ($field) use ($fields) {
    //             $child = $fields->first(fn ($child) => $child['id'] === $field['id']);

    //             if ($child) {
    //                 $field = array_merge($field, $child);
    //             }

    //             return $field;
    //         });

    //         $this->route['options']['fields'] = $extensions
    //             ->concat($fields->filter(fn ($field) => !$extensions->contains('id', $field['id'])))
    //             ->toArray();
    //     }
        
    //     // fill action data
    //     foreach ($this->route['options']['actions'] as $key => $action) {
    //         data_fill($this->route, "options.actions.{$key}.href", data_get($action, 'href') ?: Href::format(data_get($action, 'to'), $this->controller['path']));
    //         data_fill($this->route, "options.actions.{$key}.icon", null);
    //         data_fill($this->route, "options.actions.{$key}.text", null);
    //         data_fill($this->route, "options.actions.{$key}.theme", null);
    //         data_fill($this->route, "options.actions.{$key}.to", null);
    //         data_fill($this->route, "options.actions.{$key}.type", null);
    //     }

    //     // fill field data
    //     $aliases = config('backend.fields', []);

    //     foreach ($this->route['options']['fields'] as $key => $field) {
    //         data_fill($this->route, "options.fields.{$key}.disabled", false);
    //         data_fill($this->route, "options.fields.{$key}.label", str($field['id'])->headline()->toString());
    //         data_fill($this->route, "options.fields.{$key}.order", 0);
    //         data_fill($this->route, "options.fields.{$key}.type", TextField::class);

    //         // set breakpoints
    //         data_set($this->route, "options.fields.{$key}.span", Breakpoint::create($field['span'] ?? 12));

    //         // apply field aliases
    //         if (data_get($field, 'type') === null) {
    //             data_set($this->route, "options.fields.{$key}.type", TextField::class);
    //         } elseif (array_key_exists($field['type'], $aliases)) {
    //             data_set($this->route, "options.fields.{$key}.type", $aliases[$field['type']]);
    //         } else {
    //             data_set($this->route, "options.fields.{$key}.type", $field['type']);
    //         }
    //     }

    //     // finalize normalization and order fields
    //     $this->route['options']['fields'] = collect($this->route['options']['fields'])
    //         ->sortBy('order')
    //         ->values()
    //         ->toArray();
    // }
}
