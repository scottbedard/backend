<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Components\Component;

class Form extends Component
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'fields' => [],
    ];

    /**
     * Render
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('backend::renderables.form', [
            'fields' => $this->fields,
        ]);
    }
}
