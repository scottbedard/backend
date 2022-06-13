<?php

namespace Bedard\Backend\Components;

use Backend;
use Bedard\Backend\Classes\Fluent;
use Illuminate\Contracts\Support\Renderable;

class Component extends Fluent implements Renderable
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'class' => '',
        'items' => [],
        'permission' => null,
    ];

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
     * Output
     *
     * @return \Illuminate\View\View|string|callable
     */
    protected function output()
    {
        return '';
    }

    /**
     * Render
     *
     * @return \Illuminate\View\View|string|callable
     */
    final public function render()
    {
        if (!$this->permission || Backend::check(auth()->user(), $this->permission)) {
            return $this->output();
        }

        return '';
    }
}
