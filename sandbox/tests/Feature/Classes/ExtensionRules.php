<?php

namespace Tests\Feature\Classes;

class ExtensionRules extends BaseRules
{
    public function getValidationRules(): array
    {
        return array_merge_recursive(parent::getValidationRules(), [
            'foo' => ['nullable'],
            'bar' => ['string'],
        ]);
    }
}
