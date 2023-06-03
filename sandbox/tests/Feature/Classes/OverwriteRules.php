<?php

namespace Tests\Feature\Classes;

class OverwriteRules extends BaseRules
{
    public function defineValidation(): array
    {
        return [
            'foo' => ['integer'],
        ];
    }
}
