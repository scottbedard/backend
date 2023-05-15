<?php

namespace Bedard\Backend\Configuration;

class ListAction extends Configuration
{
    /**
     * Default data
     *
     * @var array
     */
    public array $defaults = [
        'href' => null,
        'icon' => null,
        'to' => null,
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public array $rules = [
        'href' => ['nullable', 'string'],
        'icon' => ['nullable', 'string'],
        'label' => ['required', 'string'],
        'to' => ['nullable', 'string'],
    ];
}
