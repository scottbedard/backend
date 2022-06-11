<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Classes\Fluent;
use Bedard\Backend\Components\Component;
use Illuminate\Contracts\Support\Renderable;
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
        'permissions' => [],
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