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
        'permission' => null,
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
    final public function provide($data)
    {
        $this->data = $data;

        foreach ($this->attributes as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $descendent) {
                    if (is_a($descendent, self::class)) {
                        $descendent->provide($data);
                    }
                }
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
