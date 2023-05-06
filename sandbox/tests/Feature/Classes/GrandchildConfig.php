<?php

namespace Tests\Feature\Classes;

use Bedard\Backend\Configuration\Configuration;

class GrandchildConfig extends Configuration
{
    public array $inherits = [
        'name',
    ];
}
