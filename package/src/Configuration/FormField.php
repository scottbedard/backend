<?php

namespace Bedard\Backend\Configuration;


class FormField extends Configuration
{
    /**
     * Auto-create child instances
     *
     * @var bool
     */
    public static bool $autocreate = false;

    /**
     * Default data
     *
     * @var array
     */
    public array $defaults = [
        'order' => 0,
        'type' => null,
    ];

    /**
     * Child properties
     *
     * @var array
     */
    public array $props = [];

    /**
     * Validation rules
     *
     * @var array
     */
    public array $rules = [
        'id' => 'required',
        'type' => ['present', 'nullable', 'string'],
    ];
}
