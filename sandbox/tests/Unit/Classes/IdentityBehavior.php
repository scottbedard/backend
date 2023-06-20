<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Behaviors\Behavior;

class IdentityBehavior extends Behavior
{
    public function identity($val)
    {
        return $val;
    }
}
