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
     * Path
     *
     * @return ?string
     */
    public function path(): ?string
    {        
        if (array_key_exists('path', $this->data)) {
            return $this->data['path'];
        }

        $id = $this->get('id');

        return str_starts_with($id, '_')
            ? null
            : str($id)->slug()->toString();
    }
}
