<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Behavior;

class AttachThingBehavior extends Behavior
{
    public function setThingAttribute()
    {
        return 'Hello world';
    }
}
