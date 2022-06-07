<?php

namespace Bedard\Backend;

use Bedard\Backend\Classes\Fluent;

class Toolbar extends Fluent
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'items' => [],
        'searchable' => false,
    ];
}
