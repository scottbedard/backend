<?php

namespace Bedard\Backend\Form;

use Bedard\Backend\Form\Field;
use Illuminate\View\View;

class TextField extends Field
{
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
