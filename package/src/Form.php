<?php

namespace Bedard\Backend;

use Bedard\Backend\Classes\Fluent;

class Form extends Fluent
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'fields' => [],
    ];

    /**
     * Subclass constructor aliases
     *
     * @var array
     */
    public static $subclasses = [
        'field' => \Bedard\Backend\Columns\Field::class,
    ];
}
