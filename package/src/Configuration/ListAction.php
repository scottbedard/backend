<?php

namespace Bedard\Backend\Configuration;

class ListAction extends Configuration
{
    /**
     * Default data
     *
     * @var array
     */
    public static array $defaults = [
        'href' => null,
        'icon' => null,
        'to' => null,
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static array $rules = [
        'href' => ['nullable', 'string'],
        'icon' => ['nullable', 'string'],
        'label' => ['required', 'string'],
        'to' => ['nullable', 'string'],
    ];
}
