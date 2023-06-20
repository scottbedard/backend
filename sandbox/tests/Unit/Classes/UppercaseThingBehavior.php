<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Behaviors\Behavior;

class UppercaseThingBehavior extends Behavior
{
    public function setThingAttribute(string $val): string
    {
        return strtoupper($val);
    }
}
