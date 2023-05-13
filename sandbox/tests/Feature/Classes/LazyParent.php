<?php

namespace Tests\Feature\Classes;

use Bedard\Backend\Configuration\Configuration;

class LazyParent extends Configuration
{
    public array $props = [
        'child' => LazyChild::class,
        'children' => [LazyChild::class],
        'keyed_children' => [LazyChild::class, 'id'],
    ];
}
