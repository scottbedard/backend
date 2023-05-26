<?php

namespace Bedard\Backend\Configuration;

use Bedard\Backend\Classes\Href;

class ListColumn extends Configuration
{
    /**
     * Construct
     *
     * @param array $yaml
     * @param ?\Bedard\Backend\Configuration\Configuration $parent
     * @param ?string $parentKey
     */
    public function __construct(array $config, ?Configuration $parent = null, ?string $parentKey = null)
    {
        data_fill($config, 'header', str($config['id'])->headline()->toString());

        parent::__construct($config, $parent, $parentKey);
    }

    /**
     * Get validation rules
     *
     * @return array
     */
    public function getValidationRules(): array
    {
        return [
            'id' => ['distinct', 'required', 'string'],
        ];
    }
}