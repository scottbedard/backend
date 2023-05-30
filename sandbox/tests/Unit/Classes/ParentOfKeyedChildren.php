<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Config;

class ParentOfKeyedChildren extends Config
{
    public function defineChildren(): array
    {
        return [
            'keyed_children' => [Noop::class, 'name'],
        ];
    }
}
