<?php

namespace Tests\Unit\FluentStubs;

use Tests\Unit\FluentStubs\Example;

class Child extends Example
{
    public $attributes = [
        'id' => 0,
    ];

    public function init($id = 0)
    {
        $this->attributes['id'] = $id;
    }
}
