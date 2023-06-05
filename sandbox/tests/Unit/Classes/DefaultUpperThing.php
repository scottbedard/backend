<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Config;

class DefaultUpperThing extends Config
{
    public function defineBehaviors(): array
    {
        return [
            DefaultUpperThingBehavior::class,
        ];
    }
}
