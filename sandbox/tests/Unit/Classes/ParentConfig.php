<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Config;

class ParentConfig extends Config
{
    public function defineChildren(): array
    {
        return [
            'child' => Child::class,
            'children' => [Child::class],
            'keyed_children' => [Child::class, 'id'],
        ];
    }
}
