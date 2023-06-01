<?php

namespace Bedard\Backend\Config;

use Bedard\Backend\Config\Traits\Permissions;

class Controller extends Config
{
    use Permissions;

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
