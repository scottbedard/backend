<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Classes\Fluent;
use Illuminate\Contracts\Support\Renderable;

class Block extends Fluent implements Renderable
{
    protected $attributes = [
        'class' => '',
        'items' => [],
        'text' => '',
    ];

    public function render()
    {
        return view('backend::components.block', [
            'class' => $this->class,
            'items' => $this->items,
            'text' => $this->text,
        ]);
    }
}