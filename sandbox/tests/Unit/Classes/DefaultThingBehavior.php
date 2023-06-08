<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Behaviors\Behavior;
use Bedard\Backend\Config\Config;

class DefaultThingBehavior extends Behavior
{
    public function getDefaultThing()
    {
        return 'thing';
    }
}