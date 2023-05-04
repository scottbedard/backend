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

    public array $config = [
        'nav' => Nav::class,
        'routes' => [Route::class, 'path'],
        'subnav' => [Subnav::class],
    ];

    public array $rules = [
        'nav' => ['present', 'nullable'],
        'permissions.*' => ['string'],
        'permissions' => ['present', 'array'],
        'routes' => ['present', 'array'],
        'subnav' => ['present', 'array'],
    ];
}
