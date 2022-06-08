<?php

namespace Tests\Unit\FluentStubs;

use Bedard\Backend\Classes\Fluent;

class Example extends Fluent
{
    public $attributes = [
        'computed' => null,
        'constructed' => null,
        'flagged' => false,
        'plain' => null,
    ];

    public static $subclasses = [
        'child' => \Tests\Unit\FluentStubs\Child::class,
    ];

    public function getComputedAttribute()
    {
        return '~' . $this->attributes['computed'] . '~';
    }

    public function init($constructed = null)
    {
        $this->constructed = $constructed;
    }

    public function setComputedAttribute($value)
    {
        $this->attributes['computed'] = strtoupper($value);
    }
}
