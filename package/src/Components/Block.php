<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Classes\Fluent;
use Illuminate\Contracts\Support\Renderable;

class Block extends Fluent implements Renderable
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
     * Data
     *
     * @var array
     */
    protected $data = null;
    
    /**
     * Provide data to child items
     *
     * @param mixed $data
     *
     * @return \Bedard\Backend\Components\Block
     */
    public function provide($data)
    {
        $this->data = $data;

        foreach ($this->items as $item) {
            $item->provide($data);
        }

        return $this;
    }

    /**
     * Render
     *
     * @return \Illuminate\View\View
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