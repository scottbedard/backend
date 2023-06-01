<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Behavior;
use Bedard\Backend\Config\Config;

class DefaultConfigBehavior extends Behavior
{
    public function getDefaultThingConfig()
    {
        return 'thing';
    }
}