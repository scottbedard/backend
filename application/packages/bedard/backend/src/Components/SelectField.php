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
    ];

    /**
     * Render
     *
     * @return \Illuminate\View\View|string|callable
     */
    protected function output()
    {
        return view('backend::renderables.select-field', array_merge($this->attributes, [
            'data' => $this->data,
        ]));
    }
}