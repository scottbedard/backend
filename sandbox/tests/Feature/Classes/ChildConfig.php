<?php

namespace Tests\Feature\Classes;

use Bedard\Backend\Configuration\Configuration;

class ChildConfig extends Configuration
{
    public array $props = [
        'grandchild' => GrandchildConfig::class,
    ];
}
