<?php

namespace Bedard\Backend\Form;

use Bedard\Backend\Form\Field;
use Illuminate\View\View;

class InputField extends Field
{
    /**
     * Default data
     *
     * @var array
     */
    public array $defaults = [
        'order' => 0,
        'span' => 12,
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public array $rules = [
        'max' => ['number'],
        'maxlength' => ['number'],
        'min' => ['number'],
        'minlength' => ['number'],
        'pattern' => ['string'],
        'placeholder' => ['string'],
        'readonly' => ['boolean'],
        'required' => ['boolean'],
    ];

    /**
     * Render
     *
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('backend::form.input', [
            'field' => $this,
        ]);
    }
}
