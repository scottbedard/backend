<?php

namespace Tests\Feature\Classes;

use Bedard\Backend\Configuration\Configuration;

class ParentConfig extends Configuration {
    protected array $properties = [
        'singular' => ChildConfig::class,
        'plural' => ChildConfig::class,
    ];
}