<?php

namespace Bedard\Backend\Configuration;

class Controller extends Configuration
{
    /**
     * Default data
     *
     * @var array
     */
    public array $defaults = [
        'model' => null,
        'permissions' => [],
        'routes' => [],
    ];

    /**
     * Child properties
     *
     * @var array
     */
    public array $props = [
        'routes' => [Route::class, 'id'],
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public array $rules = [
        'id' => ['required', 'string'],
        'model' => ['nullable', 'string'],
        'permissions' => ['present', 'array'],
        'permissions.*' => ['string'],
    ];

    /**
     * Construct
     *
     * @param array $yaml
     * @param ?Configuration $parent
     */
    public function __construct(array $config = [], ?Configuration $parent = null)
    {
        if (!array_key_exists('path', $config) && !str_starts_with($config['id'], '_')) {
            $config['path'] = str($config['id'])->slug()->toString();
        }

        parent::__construct($config, $parent);
    }
}
