<?php

namespace Tests\Feature\Classes;

use Bedard\Backend\Classes\KeyedArray;
use Bedard\Backend\Configuration\Configuration;

class ParentConfig extends Configuration
{
    public array $properties = [
        'plural' => ChildConfig::class,
        'singular' => ChildConfig::class,
    ];
}