<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Config;

class Child extends Config
{
    public function getChildren(): array
    {
        return [
            'child' => Grandchild::class,
            'children' => [Grandchild::class],
            'keyed_children' => [Grandchild::class, 'id'],
        ];
    }
}
