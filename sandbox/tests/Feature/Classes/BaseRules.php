<?php

namespace Tests\Feature\Classes;

use Bedard\Backend\Configuration\Configuration;

class BaseRules extends Configuration
{
    public function defineValidation(): array
    {
        return [
            'foo' => ['string'],
        ];
    }
}
