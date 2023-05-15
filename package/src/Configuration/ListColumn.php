<?php

namespace Bedard\Backend\Configuration;

use Bedard\Backend\Classes\Href;

class ListColumn extends Configuration
{
    /**
     * Default data
     *
     * @var array
     */
    public array $defaults = [
        // ...
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public array $rules = [
        'id' => ['distinct', 'required', 'string'],
    ];

    /**
     * Construct
     *
     * @param array $args
     */
    public function __construct(array $config, Configuration $parent = null)
    {
        data_fill($config, 'header', str($config['id'])->headline()->toString());

        parent::__construct($config, $parent);
    }
}