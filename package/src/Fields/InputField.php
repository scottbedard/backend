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
            'label' => $this->label,
            'type' => $this->type,
        ]);
    }
}
