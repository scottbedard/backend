<?php

namespace Bedard\Backend\Configuration;

class Controller extends Configuration
{
    public array $default = [
        'nav' => null,
        'permissions' => [],
        'routes' => [],
        'subnav' => [],
    ];

    public array $props = [
        // 'nav' => Nav::class,
        'routes' => [Route::class, 'id'],
        // 'subnav' => [Subnav::class],
    ];

    public array $rules = [
        // ...
    ];
}
