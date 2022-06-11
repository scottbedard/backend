<?php

namespace Bedard\Backend\Components;

class Button extends Block
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'confirm' => null,
        'icon' => null,
        'method' => null,
        'requireSelection' => false,
        'text' => 'whoa',
        'theme' => null,
        'to' => null,
    ];

    /**
     * Render
     *
     * @return \Illuminate\View\View|string
     */
    public function render($arg = null)
    {
        return view('backend::renderables.button', [
            'confirm' => $this->confirm,
            'data' => $this->data,
            'icon' => $this->icon,
            'method' => $this->method,
            'requireSelection' => $this->requireSelection,
            'text' => $this->text,
            'theme' => $this->theme,
            'to' => $this->to,
        ]);
    }
}