<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Behavior;
use Bedard\Backend\Config\Config;

class SetThingBehavior extends Behavior
{
    public function setThingAttribute(string $val): string
    {
        return strtoupper($val);
    }
}