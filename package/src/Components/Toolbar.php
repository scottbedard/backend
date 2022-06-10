<?php

namespace Bedard\Backend\Components;

class Toolbar extends Block
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'data' => [],
    ];

    /**
     * Render
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('backend::renderables.toolbar', [
            'data' => $this->data,
            'items' => $this->items,
        ]);
    }
}