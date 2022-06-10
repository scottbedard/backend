<?php

namespace Bedard\Backend\Fields;

use Bedard\Backend\Field;
use Illuminate\Database\Eloquent\Model;

class InputField extends Field
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'autofocus' => false,
        'placeholder' => null,
        'readonly' => false,
        'type' => 'input',
    ];

    /**
     * Render
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render(Model $model)
    {
        return view('backend::fields.input', [
            'autofocus' => $this->autofocus,
            'label' => $this->label,
            'placeholder' => $this->placeholder,
            'readonly' => $this->readonly,
            'required' => $this->required,
            'type' => $this->type,
            'value' => $model->{$this->id},
        ]);
    }
}
