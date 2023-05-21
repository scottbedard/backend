<?php

namespace Tests\Feature\Classes;

use Bedard\Backend\Configuration\Configuration;

class BaseRules extends Configuration
{
    public static array $rules = [
        'foo' => ['string'],
    ];
}
