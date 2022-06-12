<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Components\Block;

class Form extends Block
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
     * Providable
     *
     * @var array
     */
    protected $providable = [
        'fields',
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
            'model' => $this->data['model'],
        ]);
    }
}
