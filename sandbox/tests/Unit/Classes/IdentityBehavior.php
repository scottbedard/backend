<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Behavior;
use Bedard\Backend\Config\Config;

class IdentityBehavior extends Behavior
{
    public function identity($val)
    {
        return $val;
    }
}
