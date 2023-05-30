<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Config;

class ParentOfManyChildren extends Config
{
    public function defineChildren(): array
    {
        return [
            'children' => [Noop::class],
        ];
    }
}
