<?php

namespace Bedard\Backend\Form;

use Illuminate\View\View;

abstract class Field
{
    /**
     * Create a field
     * 
     * @param array $options
     */
    public function __construct(
        protected array $options = [],
    ) {}

    /**
     * Get field options
     *
     * @param string $path
     * @param mixed $default
     */
    public function get(string $path, $default = null)
    {
        return data_get($this->options, $path, $default);
    }

    /**
     * Render
     *
     * @return \Illuminate\View\View
     */
    abstract public function render(): View;
}