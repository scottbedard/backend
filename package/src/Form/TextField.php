<?php

namespace Bedard\Backend\Form;

use Bedard\Backend\Form\Field;
use Illuminate\View\View;

class TextField extends Field
{
    /**
     * Validation rules
     *
     * @var array
     */
    protected array $rules = [
        'max' => ['number'],
        'maxlength' => ['number'],
        'min' => ['number'],
        'minlength' => ['number'],
        'pattern' => ['string'],
        'placeholder' => ['string'],
        'readonly' => ['boolean'],
        'required' => ['boolean'],
        'stop' => ['number'],
    ];

    /**
     * Input type
     *
     * @var string
     */
    public string $type = 'text';

    /**
     * Render
     *
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('backend::form.input', [
            'options' => $this->options,
            'type' => $this->type,
        ]);
    }
}
