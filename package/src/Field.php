<?php

namespace Bedard\Backend;

use Illuminate\Support\Arr;

class Field
{
    /**
     * All of the attributes set on the fluent instance
     *
     * @var array
     */
    protected $attributes = [
        'column' => '',
        'label' => '',
    ];

    /**
     * Subclass constructor aliases
     *
     * @var array
     */
    public static $subclasses = [
        'number' => \Bedard\Backend\Fields\NumberField::class
    ];

    /**
     * Construct
     *
     * @return void
     */
    public function __construct(string $column)
    {
        $this->column = $column;
    }
}