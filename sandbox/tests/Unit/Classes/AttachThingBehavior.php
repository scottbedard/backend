<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Behaviors\Behavior;
use Bedard\Backend\Config\Config;

class AttachThingBehavior extends Behavior
{
    public function setThingAttribute()
    {
        return 'Hello world';
    }
}