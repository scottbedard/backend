<?php

namespace Tests\Feature\Classes;

use Bedard\Backend\Configuration\Configuration;

class ParentConfig extends Configuration {
    protected array $properties = [
        'child' => ChildConfig::class,
    ];
}