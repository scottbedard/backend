<?php

namespace Bedard\Backend\Fields;

use Bedard\Backend\Field;

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
        'type' => 'input',
    ];

    /**
     * Render
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('backend::fields.input', [
            'autofocus' => $this->autofocus,
            'label' => $this->label,
            'placeholder' => $this->placeholder,
            'required' => $this->required,
            'type' => $this->type,
        ]);
    }
}
