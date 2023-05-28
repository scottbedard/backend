<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Config;

class ParentOfSingleChild extends Config
{
    public function children(): array
    {
        return [
            'child' => Noop::class,
        ];
    }
}
