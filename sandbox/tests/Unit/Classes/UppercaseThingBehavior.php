<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Behavior;

class UppercaseThingBehavior extends Behavior
{
    public function setThingAttribute(string $val): string
    {
        return strtoupper($val);
    }
}
