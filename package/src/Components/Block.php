<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Components\Component;
class Block extends Component
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'class' => '',
        'items' => [],
        'permission' => '',
        'text' => '',
    ];

    /**
     * Providable
     *
     * @var array
     */
    protected $providable = [
        'items',
    ];

    /**
     * Render
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('backend::components.block', [
            'class' => $this->class,
            'items' => $this->items,
            'text' => $this->text,
        ]);
    }
}