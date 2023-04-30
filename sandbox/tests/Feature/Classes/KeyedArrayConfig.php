<?php

namespace Tests\Feature\Classes;

use Bedard\Backend\Configuration\Configuration;
use Test\Feature\Classes\ChildConfig;

class KeyedArrayConfig extends Configuration
{
    public array $keyed = [
        'things' => 'id',
    ];

    public array $properties = [
        'keyed' => ChildConfig::class,
    ];
}
