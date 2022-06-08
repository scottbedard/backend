<?php

namespace Bedard\Backend\Toolbar;

use Bedard\Backend\Classes\Fluent;

class Base extends Fluent
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'permissions' => [],
    ];

    /**
     * Render
     *
     * @param array $context
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render(array $context)
    {
        return '';
    }
}
