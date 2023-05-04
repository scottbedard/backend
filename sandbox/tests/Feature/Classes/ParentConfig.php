<?php

namespace Tests\Feature\Classes;

use Bedard\Backend\Classes\KeyedArray;
use Bedard\Backend\Configuration\Configuration;

class ParentConfig extends Configuration
{
    public array $props = [
        'child' => ChildConfig::class,
        'children' => [ChildConfig::class],
        'keyed_children' => [ChildConfig::class, 'id'],
        'other_child' => ChildConfig::class,
        'other_children' => [ChildConfig::class],
        'other_keyed_children' => [ChildConfig::class, 'id'],
    ];
}