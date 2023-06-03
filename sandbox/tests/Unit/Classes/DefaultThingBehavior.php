<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Behavior;
use Bedard\Backend\Config\Config;

class DefaultThingBehavior extends Behavior
{
    public function getDefaultThing()
    {
        return 'thing';
    }
}