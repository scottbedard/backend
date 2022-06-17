<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Components\Component;

class Button extends Component
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'action' => null,
        'confirm' => null,
        'disabled' => false,
        'icon' => null,
        'primary' => false,
        'resource' => null,
        'submit' => false,
        'text' => '',
        'to' => null,
    ];

    /**
     * Render
     *
     * @return \Illuminate\View\View|string|callable
     */
    protected function output()
    {
        return view('backend::renderables.button', array_merge($this->attributes,[
            'data' => $this->data,
        ]));
    }
}