<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Components\Field;

class InputField extends Field
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'autofocus' => false,
        'disabled' => false,
        'placeholder' => '',
        'readonly' => false,
        'required' => false,
        'type' => 'text',
    ];

    /**
     * Render
     *
     * @return \Illuminate\View\View|string
     */
    protected function output()
    {
        return fn ($model) => view('backend::renderables.input-field', [
            'autofocus' => $this->autofocus,
            'disabled' => $this->disabled,
            'id' => $this->id,
            'label' => $this->label,
            'model' => $model,
            'placeholder' => $this->placeholder,
            'readonly' => $this->readonly,
            'required' => $this->required,
            'required' => $this->required,
            'type' => $this->type,
            'uid' => $this->uid,
            'value' => $model->{$this->id},
        ]);

    }
}