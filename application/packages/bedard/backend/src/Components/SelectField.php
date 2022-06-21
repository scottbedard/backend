<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Components\Field;

class SelectField extends Field
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'disabled' => false,
        'display' => 'id',
        'options' => [],
        'placeholder' => 'Select...',
        'readonly' => false,
        'required' => false,
        'searchable' => false,
        'searchPlaceholder' => 'Search',
    ];

    /**
     * Render
     *
     * @return \Illuminate\View\View|string|callable
     */
    protected function output()
    {
        $options = is_callable($this->attributes['options'])
            ? $this->attributes['options'](null)
            : $this->attributes['options'];
        
        return view('backend::renderables.select-field', array_merge($this->attributes, [
            'options' => $options,
            'data' => $this->data,
        ]));
    }
}