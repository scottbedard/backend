<?php

namespace Bedard\Backend\Configuration;

use Bedard\Backend\Classes\Href;

class FormAction extends Configuration
{
    /**
     * Default data
     *
     * @var array
     */
    public static array $defaults = [
        'href' => null,
        'icon' => null,
        'theme' => 'default',
        'to' => null,
    ];

    /**
     * Construct
     *
     * @param array $yaml
     * @param ?\Bedard\Backend\Configuration\Configuration $parent
     * @param ?string $parentKey
     */
    public function __construct(array $config, ?Configuration $parent = null, ?string $parentKey = null)
    {
        parent::__construct($config, $parent, $parentKey);

        if (is_string($this->data['to']) && $this->data['href'] === null) {
            $this->data['href'] = Href::format($this->data['to']);
        }
    }

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
            'theme' => ['required', 'string', 'in:default,danger,primary'],
            'to' => ['nullable', 'string'],
        ];
    }
}
