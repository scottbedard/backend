<?php

namespace Tests\Feature\Classes;

class OverwriteRules extends BaseRules
{
    public function getValidationRules(): array
    {
        return [
            'foo' => ['integer'],
        ];
    }
}
