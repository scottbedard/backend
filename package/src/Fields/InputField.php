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
        'disabled' => false,
        'placeholder' => '',
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
        $this->value = $model->{$this->id};
        return view('backend::fields.input-field', [
            'field' => $this,
            // 'autofocus' => $this->autofocus,
            // 'disabled' => $this->disabled,
            // 'id' => $this->id,
            // 'label' => $this->label,
            // 'placeholder' => $this->placeholder,
            // 'readonly' => $this->readonly,
            // 'required' => $this->required,
            // 'type' => $this->type,
            // 'value' => $model->{$this->id},
        ]);
    }
}