<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Config;

class Grandchild extends Config
{
    public function getChildren(): array
    {
        return [

        ];
    }
}
