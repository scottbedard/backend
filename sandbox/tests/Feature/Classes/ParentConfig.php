<?php

namespace Tests\Feature\Classes;

use Bedard\Backend\Classes\KeyedArray;
use Bedard\Backend\Configuration\Configuration;

class ParentConfig extends Configuration
{
    protected array $properties = [
        'keyed' => [ChildConfig::class, 'id'],
        'plural' => ChildConfig::class,
        'singular' => ChildConfig::class,
    ];
}