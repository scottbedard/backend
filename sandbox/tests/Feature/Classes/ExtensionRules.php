<?php

namespace Tests\Feature\Classes;

class ExtensionRules extends BaseRules
{
    public function defineValidation(): array
    {
        return array_merge_recursive(parent::defineValidation(), [
            'foo' => ['nullable'],
            'bar' => ['string'],
        ]);
    }
}
