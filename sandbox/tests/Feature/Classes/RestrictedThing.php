<?php

namespace Tests\Feature\Classes;

use Bedard\Backend\Config\Config;
use Bedard\Backend\Config\Behaviors\Permissions;

class RestrictedThing extends Config
{
    public function defineBehaviors(): array
    {
        return [
            Permissions::class,
        ];
    }

    public function defineChildren(): array
    {
        return [
            'thing' => self::class,
            'things' => [self::class],
            'keyed_things' => [self::class, 'id'],
        ];
    }
}
