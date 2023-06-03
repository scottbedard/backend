<?php

namespace Bedard\Backend\Plugins;

use Bedard\Backend\Classes\ArrayUtil;
use Bedard\Backend\Configuration\FormAction;
use Bedard\Backend\Configuration\Configuration;
use Bedard\Backend\Exceptions\ConfigurationException;
use Bedard\Backend\Form\Field;
use Bedard\Backend\Form\InputField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;

class FormPlugin extends Plugin
{
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
        'actions' => [FormAction::class, 'id'],
        'fields' => [Field::class, 'id'],
    ];

    /**
     * Construct
     *
     * @param array $yaml
     * @param ?\Bedard\Backend\Configuration\Configuration $parent
     */
    public function __construct(array $config = [], ?Configuration $parent = null)
    {
        // construct form
        parent::__construct($config, $parent);

        // create field instances, extending parent form if necessary
        $extends = $this->get('extends');

        $create = fn ($arr) => collect($arr)
            ->map(function ($field) {
                data_fill($field, 'order', 0);
                data_fill($field, 'type', InputField::class);

                return Field::createFromType($field, $this, 'options.fields.' . $field['id']);
            })
            ->sortBy('order')
            ->values();

        if ($extends) {
            $base = $this->controller()->route($extends)?->plugin();

            if (!$base) {
                throw new ConfigurationException("Failed to extend \"{$extends}\", form not found");
            }

            $this->data['fields'] = $create(
                ArrayUtil::mergeBy($base->get('fields'), $this->get('fields'), 'id')
            );
        } else {
            $this->data['fields'] = $create($this->get('fields'));
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
     * Get validation rules
     *
     * @return array
     */
    public function defineValidation(): array
    {
        return [
            'actions' => ['present', 'array'],
            'fields' => ['present', 'array'],
            'model' => ['nullable', 'string'],
        ];
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
            'actions' => $this->get('actions'),
            'data' => $data,
            'fields' => $this->get('fields'),
        ]);
    }
}
