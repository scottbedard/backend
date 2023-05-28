<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Config;

class ParentOfSingleChild extends Config
{
    public array $children = [
        'child' => Noop::class,
    ];
}
