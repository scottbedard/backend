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
        'resource' => null,
        'text' => '',
        'theme' => null,
        'to' => null,
        'type' => 'button',
    ];

    /**
     * Render
     *
     * @return \Illuminate\View\View|string
     */
    protected function output()
    {
        return view('backend::renderables.button', [
            'action' => $this->action,
            'confirm' => $this->confirm,
            'data' => $this->data,
            'disabled' => $this->disabled,
            'icon' => $this->icon,
            'text' => $this->text,
            'theme' => $this->theme,
            'to' => $this->to,
            'type' => $this->type,
        ]);
    }
}