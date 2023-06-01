<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Behavior;

class GetThingBehavior extends Behavior
{
    public function getThingAttribute(): string
    {
        return 'hello world';
    }
}