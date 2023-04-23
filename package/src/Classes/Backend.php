<?php

namespace Bedard\Backend\Classes;

use Bedard\Backend\Classes\ViteManifest;
use Bedard\Backend\Exceptions\ControllerNotFoundException;
use Bedard\Backend\UrlNormalizer;
use Exception;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Symfony\Component\Yaml\Yaml;

class Backend
{
    /**
     * Backend config
     *
     * @var array
     */
    private array $config;

    /**
     * Create backend instance
     *
     * @param array $targets
     *
     * @return void
     */
    public function __construct(...$targets)
    {
        $config = [
            'controllers' => [],
        ];

        $parse = function (string $path) use (&$config, &$parse) {
            if (File::isDirectory($path)) {
                collect(scandir($path))
                    ->filter(fn ($p) => str_ends_with($p, '.yaml'))
                    ->each(fn ($p) => $parse("{$path}/{$p}"));

                return;
            }

            if (File::isFile($path)) {
                $key = str($path)
                    ->lower()
                    ->rtrim('.yaml')
                    ->explode('/')
                    ->last();

                $config['controllers'][$key] = Yaml::parseFile($path) ?? [];
            }
        };

        collect($targets)->flatten()->each($parse);

        $this->set($config);
    }

    /**
     * Get controller definition
     *
     * @param string $key
     *
     * @return array
     */
    public function controller(string $key): array
    {
        $name = str($key)->match('/^backend\.(\w+)\.?\w*$/')->toString() ?: null;

        $controller = data_get($this->config, "controllers.{$name}");

        if ($controller) {
            return $controller;
        }

        throw new ControllerNotFoundException($key);
    }

    /**
     * Return all backend config
     *
     * @return array
     */
    public function config(): array
    {
        return $this->config;
    }

    /**
     * Get a collection of all controllers
     *
     * @return \Illuminate\Support\Collection
     */
    public function controllers(): Collection
    {
        return collect($this->config['controllers']);
    }

    /**
     * Static constructor
     *
     * @param array $targets
     *
     * @return self
     */
    public static function from(...$targets): self
    {
        return new static(...$targets);
    }

    /**
     * Get a value from the config
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get(string $key, mixed $default = null)
    {
        return data_get($this->config, $key, $default);
    }

    /**
     * Get top-level nav
     *
     * @param Illuminate\Foundation\Auth\User $user
     *
     * @return array
     */
    public function nav(User $user = null): array
    {
        return $this
            ->controllers()
            ->filter(fn ($ctrl) => $ctrl['nav'])
            ->filter(fn ($ctrl) => !$user || $this->test($user, $ctrl['nav']['permissions']))
            ->values()
            ->reduce(function ($acc, $ctrl) {
                if (!$ctrl['nav']['href'] && $ctrl['nav']['to']) {
                    $ctrl['nav']['href'] = Href::format($ctrl['nav']['to'], $ctrl['path']);
                }

                return $acc->push($ctrl['nav']);
            }, collect())
            ->sortBy('order')
            ->values()
            ->toArray();
    }

    /**
     * Get route definition
     *
     * @param string $route
     */
    public function route(string $route): array
    {
        if (str($route)->is('backend.*.*')) {
            [, $controllerId, $routeId] = str($route)->explode('.');

            return data_get($this->config, "controllers.{$controllerId}.routes.{$routeId}");
        }

        if (str($route)->is('backend.*')) {
            $controllerId = '_root';
            $routeId = str($route)->explode('.')->last();

            return data_get($this->config, "controllers.{$controllerId}.routes.{$routeId}");
        }
        
        throw new Exception('Backend route not found: ' . $route);
    }

    /**
     * Set config data
     *
     * @param array $data
     *
     * @return void
     */
    private function set(array $config): void
    {
        $plugins = config('backend.plugins', []);

        // ensure empty yaml files don't break
        data_fill($config, 'controllers.*', []);

        // walk through config and fill values
        foreach ($config['controllers'] as $controllerKey => $controller) {
            $id = str_starts_with($controllerKey, '_') ? $controllerKey : str($controllerKey)->kebab()->toString();
            $path = str_starts_with($id, '_') ? null : $id;

            data_fill($config, "controllers.{$controllerKey}.id", $id);
            data_fill($config, "controllers.{$controllerKey}.model", null);
            data_fill($config, "controllers.{$controllerKey}.nav", null);
            data_fill($config, "controllers.{$controllerKey}.path", $path);
            data_fill($config, "controllers.{$controllerKey}.permissions", []);
            data_fill($config, "controllers.{$controllerKey}.routes", []);
            data_fill($config, "controllers.{$controllerKey}.subnav", []);

            if (data_get($config, "controllers.{$controllerKey}.nav")) {
                data_fill($config, "controllers.{$controllerKey}.nav.href", null);
                data_fill($config, "controllers.{$controllerKey}.nav.icon", null);
                data_fill($config, "controllers.{$controllerKey}.nav.label", null);
                data_fill($config, "controllers.{$controllerKey}.nav.order", 0);
                data_fill($config, "controllers.{$controllerKey}.nav.permissions", []);
                data_fill($config, "controllers.{$controllerKey}.nav.to", null);
            }

            foreach ($config['controllers'][$controllerKey]['subnav'] as $i => $subnav) {
                data_fill($config, "controllers.{$controllerKey}.subnav.{$i}.href", null);
                data_fill($config, "controllers.{$controllerKey}.subnav.{$i}.icon", null);
                data_fill($config, "controllers.{$controllerKey}.subnav.{$i}.label", null);
                data_fill($config, "controllers.{$controllerKey}.subnav.{$i}.permissions", []);
                data_fill($config, "controllers.{$controllerKey}.subnav.{$i}.to", null);
            }

            foreach ($config['controllers'][$controllerKey]['routes'] as $routeKey => $route) {
                if (!$route) {
                    data_set($config, "controllers.{$controllerKey}.routes.{$routeKey}", []);
                }
                
                data_fill($config, "controllers.{$controllerKey}.routes.{$routeKey}.model", $config['controllers'][$controllerKey]['model']);
                data_fill($config, "controllers.{$controllerKey}.routes.{$routeKey}.options", ['view' => 'backend::missing-plugin',]);
                data_fill($config, "controllers.{$controllerKey}.routes.{$routeKey}.path", null);
                data_fill($config, "controllers.{$controllerKey}.routes.{$routeKey}.permissions", []);
                data_fill($config, "controllers.{$controllerKey}.routes.{$routeKey}.plugin", 'blade');

                $plugin = data_get($plugins, $config['controllers'][$controllerKey]['routes'][$routeKey]['plugin']);
            
                if ($plugin) {
                    data_set($config, "controllers.{$controllerKey}.routes.{$routeKey}.plugin", $plugin);
                }
            }
        }

        $this->validate($config);
        
        $this->config = $config;
    }

    /**
     * Get subnav
     *
     * @param string $routeName
     * @param Illuminate\Foundation\Auth\User $user
     *
     * @return array
     */
    public function subnav(string $routeName, User $user = null): array
    {
        $controller = $this->controller($routeName);

        return collect($controller['subnav'])
            ->filter(fn ($subnav) => !$user || $this->test($user, $subnav['permissions']))
            ->reduce(function ($acc, $link) use ($controller) {
                if (!$link['href'] && $link['to']) {
                    $link['href'] = Href::format($link['to'], $controller['path']);
                }

                return [...$acc, $link];
            }, []);
    }

    /**
     * Test for a set of permissions
     *
     * @param Illuminate\Foundation\Auth\User $user
     * @param array $permissions
     * 
     * @return bool
     */
    private function test(User $user, array $permissions): bool
    {
        try {
            foreach ($permissions as $permission) {
                if (!$user->hasPermissionTo($permission)) return false;
            }
        } catch (PermissionDoesNotExist $e) {
            return false;
        }

        return true;
    }

    /**
     * Validate config
     *
     * @param array $config
     *
     * @return void
     */
    private function validate(array $config): void
    {
        $validator = Validator::make($config, [
            'controllers.*.model' => ['present', 'nullable', 'string'],
            'controllers.*.nav' => ['present', 'nullable', 'array'],
            'controllers.*.nav.icon' => ['nullable', 'string'],
            'controllers.*.nav.label' => ['nullable', 'string'],
            'controllers.*.nav.order' => ['int'],
            'controllers.*.nav.permissions' => ['array'],
            'controllers.*.nav.to' => ['nullable', 'string'],
            'controllers.*.path' => ['present', 'nullable', 'string'],
            'controllers.*.permissions' => ['present', 'array'],
            'controllers.*.permissions.*' => ['string'],
            'controllers.*.routes' => ['present', 'nullable', 'array'],
            'controllers.*.routes.*.model' => ['present', 'nullable', 'string'],
            'controllers.*.routes.*.options' => ['present', 'array'],
            'controllers.*.routes.*.permissions' => ['present', 'array'],
            'controllers.*.routes.*.permissions.*' => ['string'],
            'controllers.*.subnav' => ['present', 'array'],
            'controllers.*.subnav.*.icon' => ['present', 'nullable', 'string'],
            'controllers.*.subnav.*.label' => ['present', 'nullable', 'string'],
            'controllers.*.subnav.*.permissions' => ['present', 'array'],
            'controllers.*.subnav.*.to' => ['present', 'nullable', 'string'],
        ]);

        if ($validator->fails()) {
            throw new Exception('Invalid backend config: ' . $validator->errors()->first());
        }
    }
}
