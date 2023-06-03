<?php

namespace Bedard\Backend\Config;

use Bedard\Backend\Config\Behaviors\Permissions;

class Controller extends Config
{
    /**
     * Define behaviors
     *
     * @return array
     */
    public function defineBehaviors(): array
    {
        return [
            Permissions::class,
        ];
    }

    /**
     * Define child config
     *
     * @return array
     */
    public function defineChildren(): array
    {
        return [
            'nav' => [Nav::class],
        ];
    }
}
