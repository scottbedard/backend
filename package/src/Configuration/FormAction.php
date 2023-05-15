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
    public array $defaults = [
        'href' => null,
        'icon' => null,
        'theme' => 'default',
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
        'theme' => ['required', 'string'],
        'to' => ['nullable', 'string'],
    ];

    /**
     * Construct
     *
     * @param array $args
     */
    public function __construct(array $config, Configuration $parent = null)
    {
        parent::__construct($config, $parent);

        if (is_string($this->data['to']) && $this->data['href'] === null) {
            $this->data['href'] = Href::format($this->data['to']);
        }
    }
}
