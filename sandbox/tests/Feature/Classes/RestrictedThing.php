<?php

namespace Tests\Feature\Classes;

use Bedard\Backend\Config\Behaviors\Permissions;
use Bedard\Backend\Config\Config;

class RestrictedThing extends Config
{
    public function defineBehaviors(): array
    {
        return [
            Permissions::class,
        ];
    }
}
