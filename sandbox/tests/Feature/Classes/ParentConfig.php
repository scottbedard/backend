<?php

namespace Tests\Feature\Classes;

use Bedard\Backend\Configuration\Configuration;

class ParentConfig extends Configuration
{
    public static array $defaults = [
        'name' => 'foo',
    ];

    public array $props = [
        'child' => ChildConfig::class,
        'children' => [ChildConfig::class],
        'keyed_children' => [ChildConfig::class, 'id'],
    ];
}
