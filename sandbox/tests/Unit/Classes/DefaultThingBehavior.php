<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Behavior;

class DefaultThingBehavior extends Behavior
{
    public function getDefaultThing()
    {
        return 'thing';
    }
}
