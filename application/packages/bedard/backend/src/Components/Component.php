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
        'context' => null,
        'permission' => null,
    ];

    /**
     * Get html from render function
     *
     * @return string
     */
    final public function html($data = null)
    {
        $output = $this->render();

        if (is_callable($output)) {
            return $output($data);
        }

        return $output;
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
        if ($this->context && data_get($this->data, 'context') !== $this->context) {
            return;
        }

        if (!Backend::check(auth()->user(), $this->permission)) {
            return;
        }
        
        return $this->output();
    }
}
