<?php

namespace Bedard\Backend\Configuration;

use Bedard\Backend\Classes\Href;

class Nav extends Configuration
{
    /**
     * Default data
     *
     * @var array
     */
    public array $defaults = [
        'href' => null,
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
        'href' => ['nullable', 'string'],
        'icon' => ['nullable', 'string'],
        'label' => ['required', 'string'],
        'order' => ['required', 'int'],
        'permissions.*' => ['string'],
        'permissions' => ['present', 'array'],
        'to' => ['nullable', 'string'],
    ];

    /**
     * Format the href attribute
     *
     * @return ?string
     */
    public function href(): ?string
    {
        return $this->get('href') ?? Href::format($this->get('to'), $this->closest(Controller::class)?->get('id'));
    }
}