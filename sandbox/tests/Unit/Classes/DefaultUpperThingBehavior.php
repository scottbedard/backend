<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Behaviors\Behavior;
use Bedard\Backend\Config\Config;

class DefaultUpperThingBehavior extends Behavior
{
    public function getDefaultUpperThing(array $config): string
    {
        return strtoupper(data_get($config, 'thing', ''));
    }
}