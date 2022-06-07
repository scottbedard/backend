<?php

namespace Bedard\Backend;

use Bedard\Backend\Classes\Fluent;
use Bedard\Backend\Traits\InheritParentAttrs;

class Field extends Fluent
{
    use InheritParentAttrs;

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
     * Init
     *
     * @param string $key
     *
     * @return void
     */
    public function init(string $column = '')
    {
        $this->attributes['column'] = $column;
    }
}