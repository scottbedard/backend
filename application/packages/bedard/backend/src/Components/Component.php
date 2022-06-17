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
        if (!$this->permission || Backend::check(auth()->user(), $this->permission)) {
            return $this->output();
        }

        return '';
    }
}
