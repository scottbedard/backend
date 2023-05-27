<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Config;

class Defaults extends Config
{
    public function getDefaultAttributes(): array
    {
        return [
            'foo' => 'bar',
            'overwrite' => 'original value',
        ];
    }
}
