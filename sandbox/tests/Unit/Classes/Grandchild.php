<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Config;

class Grandchild extends Config
{
    public function defineValidation(): array
    {
        return [
            'invalid' => 'prohibited', // <- allows us to force validation errors
        ];
    }
}
