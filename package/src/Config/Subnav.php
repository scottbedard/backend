<?php

namespace Bedard\Backend\Config;

use Bedard\Backend\Config\Behaviors\Permissions;
use Bedard\Backend\Config\Behaviors\ToHref;

class Subnav extends Config
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
            ToHref::class,
        ];
    }

    /**
     * Test if the subnav is active
     *
     * @return bool
     */
    public function isActive(): bool
    {
        $route = request()->route();

        $controllerOrRoute = $route->parameter('controllerOrRoute');
        
        $route = $route->parameter('route');

        return $this->to === "backend.{$controllerOrRoute}.{$route}";
    }
}
