<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Config;

class ParentOfSingleChild extends Config
{
    public function getChildren(): array
    {
        return [
            'child' => Noop::class,
        ];
    }
}
