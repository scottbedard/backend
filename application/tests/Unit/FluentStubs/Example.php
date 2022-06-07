<?php

namespace Tests\Unit\FluentStubs;

use Bedard\Backend\Classes\Fluent;

class Example extends Fluent
{
    protected $attributes = [
        'computed' => null,
        'constructed' => null,
        'flagged' => false,
        'plain' => null,
    ];

    protected static $subclasses = [
        'child' => \Tests\Unit\FluentStubs\Child::class,
    ];

    public function __construct($constructed = null)
    {
        $this->constructed = $constructed;
    }

    public function getComputedAttribute()
    {
        return '~' . $this->attributes['computed'] . '~';
    }

    public function setComputedAttribute($value)
    {
        $this->attributes['computed'] = strtoupper($value);
    }
}
