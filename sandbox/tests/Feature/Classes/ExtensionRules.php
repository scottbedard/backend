<?php

namespace Tests\Feature\Classes;

class ExtensionRules extends BaseRules
{
    public static array $rules = [
        'foo' => ['nullable'],
        'bar' => ['string'],
    ];
}
