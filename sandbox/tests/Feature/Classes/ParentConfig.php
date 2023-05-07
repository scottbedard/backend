<?php

namespace Tests\Feature\Classes;

use Bedard\Backend\Configuration\Configuration;

class ParentConfig extends Configuration
{
    public array $defaults = [
        'name' => 'foo',
    ];

    public array $props = [
        'child' => ChildConfig::class,
    ];
}