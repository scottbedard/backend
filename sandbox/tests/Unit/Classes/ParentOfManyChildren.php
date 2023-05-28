<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Config;

class ParentOfManyChildren extends Config
{
    public function getChildren(): array
    {
        return [
            'children' => [Noop::class],
        ];
    }
}
