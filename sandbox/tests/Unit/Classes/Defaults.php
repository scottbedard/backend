<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Config;

class Defaults extends Config
{
    public function getDefaultConfig(): array
    {
        return [
            'foo' => 'bar',
            'overwrite' => 'original value',
        ];
    }

    public function getDefaultUpperThing(array $config): string
    {
        return strtoupper(data_get($config, 'thing', ''));
    }
}
