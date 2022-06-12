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
        'action' => null,
        'confirm' => null,
        'icon' => null,
        'requireSelection' => false,
        'resource' => null,
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
            'action' => $this->action,
            'confirm' => $this->confirm,
            'data' => $this->data,
            'icon' => $this->icon,
            'requireSelection' => $this->requireSelection,
            'resource' => $this->data['resource'],
            'text' => $this->text,
            'theme' => $this->theme,
            'to' => $this->to,
        ]);
    }
}