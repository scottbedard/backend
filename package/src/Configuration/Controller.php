<?php

namespace Bedard\Backend\Configuration;

class Controller extends Configuration
{
    public array $defaults = [
        'model' => null,
        'routes' => [],
    ];

    public array $props = [
        'routes' => [Route::class, 'id'],
    ];

    public array $rules = [
        'model' => ['nullable', 'string']
    ];
}
