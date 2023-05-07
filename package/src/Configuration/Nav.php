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
        'to' => ['required' => 'string'],
    ];
}