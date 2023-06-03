<?php

namespace Bedard\Backend\Config;

use Bedard\Backend\Config\Behaviors\Permissions;

class Nav extends Config
{
    public function defineBehaviors(): array
    {
        return [
            Permissions::class,
        ];
    }
}
