<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Classes\Fluent;
use Illuminate\Contracts\Support\Renderable;

class Component extends Fluent implements Renderable
{
    /**
     * Data
     *
     * @var array
     */
    protected $data = null;

    /**
     * Providable
     *
     * @var array
     */
    protected $providable = [];
    
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

        foreach ($this->providable as $providable) { 
            foreach ($this->{$providable} as $child) {
                $child->provide($data);
            } 
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
    }
}
