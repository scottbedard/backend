<?php

namespace Tests\Unit\FluentStubs;

use Bedard\Backend\Classes\Fluent;

class Child extends Fluent
{
    protected $attributes = [
        'id' => 0,
    ];

    public function __construct($id)
    {
        $this->id = $id;
    }
}
