<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Behavior;
use Bedard\Backend\Config\Config;

class AttachThingBehavior extends Behavior
{
    public function setThingAttribute()
    {
        return 'Hello world';
    }
}