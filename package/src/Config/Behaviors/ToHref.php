<?php

namespace Bedard\Backend\Config\Behaviors;

use Bedard\Backend\Config\Backend;
use Bedard\Backend\Config\Config;
use Illuminate\Support\Facades\Route;

class ToHref extends Behavior
{
    /**
     * Construct
     *
     * @param Config $config
     * @param array $raw
     * @param string $for
     *
     * @return void
     */
    public function __construct(Config $config, array $raw)
    {
        parent::__construct($config, $raw);
    }

    /**
     * Get default href
     *
     * @return ?string
     */
    public function getDefaultHref(): ?string
    {
        return null;
    }

    /**
     * Get default to
     *
     * @return ?string
     */
    public function getDefaultTo(): ?string
    {
        return null;
    }

    /**
     * Set href
     *
     * @return string|null
     */
    public function getHrefAttribute(): string|null
    {
        $href = data_get($this->raw, 'href');

        if ($href) {
            return $href;
        }

        $to = data_get($this->raw, 'to');

        if (!is_string($to)) {
            return $to;
        }
        
        if (Route::has($to)) {
            return route($to);
        }

        if (str($to)->is('backend.*.*')) {
            [, $controllerId, $routeId] = explode('.', $to);

            $controller = $this
                ->config
                ->closest(Backend::class)
                ->controller($controllerId);

            if ($controller) {
                $route = $controller
                    ->routes
                    ->first(fn ($r) => $r->id === $routeId);

                if ($route) {
                    return route('backend.controller.route', [
                        'controllerOrRoute' => $controller->path,
                        'route' => $route->path,
                    ]);
                }
            }          
        }

        return $to;
    }
}