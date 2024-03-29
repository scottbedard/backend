<?php

namespace Bedard\Backend\Config;

use Bedard\Backend\Config\Behaviors\Permissions;
use Bedard\Backend\Config\Behaviors\ToHref;

class Nav extends Config
{
    public function defineBehaviors(): array
    {
        return [
            Permissions::class,
            ToHref::class,
        ];
    }
}
