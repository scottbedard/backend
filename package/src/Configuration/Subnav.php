<?php

namespace Bedard\Backend\Configuration;

class Subnav extends Configuration
{
    public array $defaults = [
        'icon' => null,
        'label' => '',
        'to' => '',
    ];

    public array $properties = [
        // ...
    ];

    public array $rules = [
        'icon' => ['nullable', 'string'],
        'label' => ['string'],
        'to' => ['string'],
    ];
}
