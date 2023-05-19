<?php

namespace Bedard\Backend\Configuration;

use Bedard\Backend\Classes\Bouncer;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Collection;

class Controller extends Configuration
{
    /**
     * Default data
     *
     * @var array
     */
    public array $defaults = [
        'model' => null,
        'nav' => [],
        'permissions' => [],
        'routes' => [],
    ];

    /**
     * Child properties
     *
     * @var array
     */
    public array $props = [
        'nav' => [Nav::class],
        'routes' => [Route::class, 'id'],
        'subnav' => [Nav::class],
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public array $rules = [
        'id' => ['required', 'string'],
        'model' => ['nullable', 'string'],
        'permissions.*' => ['string'],
        'permissions' => ['present', 'array'],
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
    }

    /**
     * Get route by id
     *
     * @param string $id
     *
     * @return ?\Bedard\Backend\Configuration\Route
     */
    public function route(string $id): ?Route
    {
        return $this
            ->get('routes')
            ->first(fn ($r) => $r->get('id') === $id);
    }

    /**
     * Get subnav items
     * 
     * @param ?\Illuminate\Foundation\Auth\User $user
     *
     * @return \Illuminate\Support\Collection
     */
    public function subnav(?User $user = null): Collection
    {
        if ($user && !Bouncer::check($user, $this->get('permissions'))) {
            return collect();
        }

        return $this->get('subnav')
            ->filter(fn ($subnav) => !$user || Bouncer::check($user, $subnav->get('permissions')))
            ->sortBy('order')
            ->values();
    }

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
