<?php

namespace Bedard\Backend\Config;

use Bedard\Backend\Exceptions\ConfigException;
use Bedard\Backend\Rules\DistinctString;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Symfony\Component\Yaml\Yaml;

class Backend extends Config
{
    /**
     * Create backend config instance
     * 
     * @param array $files
     *
     * @return self
     */
    public function __construct(...$files)
    {
        // parse controller data from yaml files
        $controllers = [];

        $parse = function (string $path) use (&$controllers, &$parse) {
            if (File::isDirectory($path)) {
                collect(scandir($path))
                    ->filter(fn ($p) => str_ends_with($p, '.yaml'))
                    ->each(fn ($p) => $parse("{$path}/{$p}"));
                
                return;
            }

            $key = str($path)
                ->lower()
                ->rtrim('.yaml')
                ->explode('/')
                ->last();

            $controllers[$key] = Yaml::parseFile($path) ?? [];
        };

        collect($files)->flatten()->each($parse);

        // set the default controller id and path
        // this is set here rather than the controller so it's ready for distinct string validation
        foreach ($controllers as $key => $controller) {
            if (!array_key_exists('id', $controller)) {
                $controllers[$key]['id'] = str_starts_with($key, '_')
                    ? $key
                    : str($key)->slug()->toString();
            }

            if (!array_key_exists('path', $controller)) {
                $controllers[$key]['path'] = str_starts_with($key, '_')
                    ? null
                    : str($controllers[$key]['id'])->slug()->toString();
            }
        }
        
        parent::__construct([
            'controllers' => $controllers,
        ]);

        $this->validate();
    }

    /**
     * Get controller
     *
     * @param string $id
     *
     * @return ?\Bedard\Backend\Config\Controller
     */
    public function controller(string $id): ?Controller
    {
        return $this->controllers->first(fn ($controller) => $controller->id === $id);
    }

    /**
     * Define children
     *
     * @return array
     */
    public function defineChildren(): array
    {
        return [
            'controllers' => [Controller::class, 'id'],
        ];
    }

    /**
     * Get validation rules
     *
     * @return array
     */
    public function defineValidation(): array
    {
        return [
            'controllers.*.id' => ['required', new DistinctString('insensitive')],
            'controllers.*.path' => ['present', new DistinctString('insensitive', 'nullable')],
        ];
    }

    /**
     * Get nav items
     *
     * @return \Illuminate\Support\Collection
     */
    public function getNavAttribute(): Collection
    {
        $user = auth()->user();
    
        return $this
            ->controllers
            ->map(fn ($controller) => $controller->nav)
            ->filter(fn ($controller) => $controller)
            ->flatten()
            ->sortBy('order')
            ->values();
    }

    /**
     * Get route for the current request
     *
     * @return ?\Bedard\Backend\Config\Route
     */
    public function getCurrentRouteAttribute(): ?Route
    {
        return $this->route(request('controllerOrRoute'), request('route'));
    }

    /**
     * All backend routes
     *
     * @param string|null $controller
     * @param string|null $route
     *
     * @return ?\Bedard\Backend\Config\Route
     */
    public function getRoutesAttribute()
    {
        return $this
            ->controllers
            ->map(fn ($controller) => $controller->routes)
            ->flatten()
            ->values();
    }

    /**
     * Get route
     *
     * @param \Illuminate\Http\Request|string|null $controllerOrRoute
     * @param string|null $route
     * 
     * @return ?\Bedard\Backend\Config\Route
     */
    public function route(?string $controllerOrRoute = null, ?string $route = null): ?Route
    {
        // find top-level index
        if ($controllerOrRoute === null && $route === null) {
            $topLevelIndex = $this
                ->controllers
                ->filter(fn ($controller) => $controller->path === null)
                ->map(fn ($controller) => $controller->routes)
                ->flatten()
                ->last(fn ($r) => $r->path === null);

            if ($topLevelIndex) {
                return $topLevelIndex;
            }

            throw new ConfigException("Backend index not found");
        }

        // find index or top-level route
        if ($route === null) {
            $controllerIndex = $this
                ->controller($controllerOrRoute)
                ?->routes
                ->first(fn ($r) => $r->path === null);

            if ($controllerIndex) {
                return $controllerIndex;
            }
            
            $topLevelRoute = $this
                ->controllers
                ->filter(fn ($controller) => $controller->path === null)
                ->map(fn ($controller) => $controller->routes)
                ->flatten()
                ->first(fn ($r) => $r->path === $controllerOrRoute);
                
            if ($topLevelRoute) {
                return $topLevelRoute;
            }

            throw new ConfigException("Backend route not found [{$route}]");
        }

        // otherwise find controller routes
        $controllerRoute = $this
            ->controllers
            ->first(fn ($c) => $c->path === $controllerOrRoute)
            ?->routes
            ->first(fn ($r) => $r->path === $route);

        if ($controllerRoute) {
            return $controllerRoute;
        }

        throw new ConfigException("Backend route not found [{$controllerOrRoute}.{$route}]");
    }
}