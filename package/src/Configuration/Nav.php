<?php

namespace Bedard\Backend\Configuration;

use Bedard\Backend\Traits\ToHref;

class Nav extends Configuration
{
    use ToHref;

    /**
     * Default data
     *
     * @var array
     */
    public static array $defaults = [
        'href' => null,
        'icon' => null,
        'order' => 0,
        'permissions' => [],
    ];

    /**
     * Get validation rules
     *
     * @return array
     */
    public function defineValidation(): array
    {
        return [
            'href' => ['nullable', 'string'],
            'icon' => ['nullable', 'string'],
            'label' => ['required', 'string'],
            'order' => ['required', 'int'],
            'permissions.*' => ['string'],
            'permissions' => ['present', 'array'],
            'to' => ['nullable', 'string'],
        ];
    }
}