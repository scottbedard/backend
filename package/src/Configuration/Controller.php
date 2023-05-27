<?php

namespace Bedard\Backend\Configuration;

use Bedard\Backend\Classes\Bouncer;
use Bedard\Backend\Traits\Permissions;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Collection;

class Controller extends Configuration
{
    use Permissions;

    /**
     * Default data
     *
     * @var array
     */
    public static array $defaults = [
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
     * Get config data
     *
     * @param string $path
     * @param mixed $default
     *
     * @return mixed
     */
    public function get(string $path, $default = null)
    {
        if ($path === 'path') {
            return $this->path();
        }

        return parent::get($path, $default);
    }

    /**
     * Get validation rules
     *
     * @return array
     */
    public function getValidationRules(): array
    {
        return [
            'id' => ['required', 'string'],
            'model' => ['nullable', 'string'],
            'permissions.*' => ['string'],
            'permissions' => ['present', 'array'],
        ];
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
        if (array_key_exists('path', $this->config)) {
            return $this->config['path'];
        }

        $id = $this->config['id'];

        return str_starts_with($id, '_')
            ? null
            : str($id)->slug()->toString();
    }
}
