<?php

namespace Tests\Feature\Classes;

use Bedard\Backend\Classes\KeyedArray;
use Bedard\Backend\Configuration\Configuration;

class TestConfig extends Configuration
{
    public array $default = [
        'array' => [],
        'bool' => true,
        'int' => 1,
        'null' => null,
        'string' => 'string',
    ];

    public array $props = [
        'child' => BlankConfig::class,
        'children' => [BlankConfig::class],
        'keyed_children' => [BlankConfig::class, 'id'],
        'other_child' => BlankConfig::class,
        'other_children' => [BlankConfig::class],
        'other_keyed_children' => [BlankConfig::class, 'id'],
    ];
}