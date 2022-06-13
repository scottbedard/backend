<?php

namespace Bedard\Backend\Components;

use Backend;

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
        'disabled' => false,
        'icon' => null,
        'resource' => null,
        'text' => 'whoa',
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
        $user = auth()->user();
        
        if (!Backend::check($user, $this->permission)) {
            return null;
        }
    
        return view('backend::renderables.button', [
            'action' => $this->action,
            'confirm' => $this->confirm,
            'data' => $this->data,
            'disabled' => $this->disabled,
            'icon' => $this->icon,
            'resource' => $this->data['resource'],
            'text' => $this->text,
            'theme' => $this->theme,
            'to' => $this->to,
            'type' => $this->type,
        ]);
    }
}