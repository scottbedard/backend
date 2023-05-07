<?php

namespace Bedard\Backend\Configuration;

class Nav extends Configuration
{
    /**
     * Default data
     *
     * @var array
     */
    public array $defaults = [
        'icon' => null,
        'order' => 0,
        'permissions' => [],
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public array $rules = [
        'icon' => ['nullable', 'string'],
        'label' => ['required', 'string'],
        'order' => ['required', 'int'],
        'permissions.*' => ['string'],
        'permissions' => ['present', 'array'],
        'to' => ['required' => 'string'],
    ];
}