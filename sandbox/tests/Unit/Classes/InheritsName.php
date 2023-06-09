<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Config;

class InheritsName extends Config
{
    public function defineInherits(): array
    {
        return ['name'];
    }
}
