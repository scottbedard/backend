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
    public function render()
    {
        return fn ($model) => $this->view('backend::renderables.input-field', [
            'autofocus' => $this->autofocus,
            'disabled' => $this->disabled,
            'label' => $this->label,
            'model' => $model,
            'id' => $this->id,
            'placeholder' => $this->placeholder,
            'readonly' => $this->readonly,
            'required' => $this->required,
            'required' => $this->required,
            'type' => $this->type,
            'value' => $model->{$this->id},
        ]);

    }
}