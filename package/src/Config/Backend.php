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
     * @param string|null $controller
     * @param string|null $route
     * 
     * @return ?\Bedard\Backend\Config\Route
     */
    public function route(?string $controller = null, ?string $route = null): ?Route
    {
        // root pages
        if ($controller === null) {
            $config = $this
                ->controllers
                ->filter(fn ($controller) => $controller->path === null)
                ->map(fn ($controller) => $controller->routes)
                ->flatten()
                ->last(fn ($r) => $r->path === $route);
                
            if ($config) {
                return $config;
            }

            throw new ConfigException("Core route not found [{$route}]");
        }

        $config = $this
            ->controllers
            ->last(fn ($c) => $c->path === $controller)
            ?->routes
            ->last(fn ($r) => $r->path === $route);

        if ($config) {
            return $config;
        }

        throw new ConfigException("Controller route not found [{$controller}.{$route}]");
    }

    /**
     * Get subnav items
     *
     * @param string|null $controller
     * @param string|null $route
     *
     * @return array
     */
    public function subnav(?string $controller = null, ?string $route = null): array
    {
        $route = $this->route($controller, $route);

        return [];
    }
}