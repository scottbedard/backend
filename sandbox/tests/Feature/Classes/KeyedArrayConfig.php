<?php

namespace Tests\Feature\Classes;

use Bedard\Backend\Configuration\Configuration;
use Test\Feature\Classes\ChildConfig;

class KeyedArrayConfig extends Configuration
{
    protected array $keyed = [
        'things' => 'id',
    ];

    protected array $properties = [
        'keyed' => ChildConfig::class,
    ];
}
