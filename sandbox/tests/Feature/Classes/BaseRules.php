<?php

namespace Tests\Feature\Classes;

use Bedard\Backend\Configuration\Configuration;

class BaseRules extends Configuration
{
    public function getValidationRules(): array
    {
        return [
            'foo' => ['string'],
        ];
    }
}