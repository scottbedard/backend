<?php

namespace Tests\Unit\Stubs;

use Tests\Unit\Stubs\Example;

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
