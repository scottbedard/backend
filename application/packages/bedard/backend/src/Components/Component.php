<?php

namespace Bedard\Backend\Components;

use Backend;
use Bedard\Backend\Classes\Fluent;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class Component extends Fluent implements Renderable, Arrayable
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'context' => null,
        'id' => null,
        'permission' => null,
    ];

    /**
     * Handler ID
     *
     * @var string
     */
    protected $handlerId = null;

    /**
     * Flatten component into an array with descendent components
     *
     * @return array
     */
    final public function flatten()
    {
        $tree = [$this];

        foreach ($this->attributes as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $descendent) {
                    if (is_a($descendent, self::class)) {
                        array_push($tree, ...$descendent->flatten());
                    }
                }
            }
        }

        return $tree;
    }

    /**
     * Component handler.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function handle(Request $request)
    {
    }

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

    /**
     * Walk across a components descendent tree.
     */
    public function walk(callable $fn)
    {
        $family = $this->flatten();
        
        foreach ($family as $node) {
            $fn($node);
        }
    }
}
