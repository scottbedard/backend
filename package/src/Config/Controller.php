<?php

namespace Bedard\Backend\Config;

use Bedard\Backend\Config\Behaviors\Permissions;

class Controller extends Config
{
    /**
     * Define behaviors
     *
     * @return array
     */
    public function defineBehaviors(): array
    {
        return [
            Permissions::class,
        ];
    }

    /**
     * Define child config
     *
     * @return array
     */
    public function defineChildren(): array
    {
        return [
            'nav' => [Nav::class],
            'routes' => [Route::class, 'id'],
            'subnav' => [Subnav::class],
        ];
    }

    /**
     * Define validation rules
     *
     * @return array
     */
    public function defineValidation(): array
    {
        return [
            'id' => ['required', 'string', 'alpha_dash'],
            'path' => ['present', 'nullable', 'string', 'alpha_dash'],
        ];
    }

    /**
     * Get default config
     *
     * @return array
     */
    public function getDefaultConfig(): array
    {
        return [
            'nav' => null,
            'routes' => [],
            'subnav' => [],
        ];
    }

    /**
     * Get route by ID
     *
     * @return ?\Bedard\Backend\Config\Route
     */
    public function route(string $routeId): ?Route
    {
        return $this
            ->routes
            ->first(fn ($route) => $route->id === $routeId);
    }
}
