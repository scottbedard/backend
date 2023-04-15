<?php

namespace Bedard\Backend\Classes;

use Bedard\Backend\Classes\ViteManifest;
use Bedard\Backend\Exceptions\ControllerNotFoundException;
use Exception;
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
    public readonly array $config;

    /**
     * Create backend instance
     *
     * @param array $targets
     *
     * @return void
     */
    public function __construct(string|array $targets = [])
    {
        $config = [
            'controllers' => [],
        ];

        if (is_string($targets)) {
            $name = str($targets)->lower()->rtrim('.yaml')->explode('/')->last();
            $config['controllers'][$name] = Yaml::parseFile($targets) ?? [];
        } elseif (is_array($targets)) {
            foreach ($targets as $target) {
                if (File::isDirectory($target)) {
                    $files = collect(scandir($target))
                        ->filter(fn ($file) => str_ends_with($file, '.yaml'))
                        ->map(fn ($file) => $target . '/' . $file)
                        ->toArray();

                    foreach ($files as $file) {
                        $name = str($file)->lower()->rtrim('.yaml')->explode('/')->last();
                        $config['controllers'][$name] = Yaml::parseFile($file) ?? [];
                    }
                } else {
                    $name = str($target)->lower()->rtrim('.yaml')->explode('/')->last();
                    $config['controllers'][$name] = Yaml::parseFile($target) ?? [];
                }
            }
        }


        $this->config = $this->normalize($config);

        $this->validate();
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
        $name = str($key)->is('backend.*')
            ? str($key)->ltrim('backend.')->explode('.')->first()
            : $key;

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
     * Get top-level nav
     *
     * @param mixed $user
     *
     * @return array
     */
    public function nav($user = null): array
    {
        $nav = [];

        foreach ($this->config['controllers'] as $controllerKey => $controller) {
            if ($controller['nav']) {
                array_push($nav, $controller['nav']);
            }
        }
        
        return array_filter($nav, function ($button) use ($user) {
            if ($user) {
                try {
                    foreach ($button['permissions'] as $permission) {
                        if (!$user->hasPermissionTo($permission)) {
                            return false;
                        }
                    }
                } catch (PermissionDoesNotExist $e) {
                    return false;
                }
            }


            return true;
        });
    }

    /**
     * Normalize config
     *
     * @return array
     */
    private function normalize(array $config): array
    {
        $plugins = config('backend.plugins', []);

        data_fill($config, 'controllers.*', []);

        foreach ($config['controllers'] as $controllerKey => $controller) {
            $id = str_starts_with('_', $controllerKey) ? $controllerKey : str($controllerKey)->kebab()->toString();
            
            data_fill($config, "controllers.{$controllerKey}.id", $id);
            data_fill($config, "controllers.{$controllerKey}.model", null);
            data_fill($config, "controllers.{$controllerKey}.nav", null);
            data_fill($config, "controllers.{$controllerKey}.nav.permissions", []);
            data_fill($config, "controllers.{$controllerKey}.path", $id);
            data_fill($config, "controllers.{$controllerKey}.permissions", []);
            data_fill($config, "controllers.{$controllerKey}.routes", []);
            data_fill($config, "controllers.{$controllerKey}.subnav", []);

            if (data_get($config, "controllers.{$controllerKey}.nav")) {
                data_fill($config, "controllers.{$controllerKey}.nav.href", null);
                data_fill($config, "controllers.{$controllerKey}.nav.icon", null);
                data_fill($config, "controllers.{$controllerKey}.nav.label", null);
                data_fill($config, "controllers.{$controllerKey}.nav.order", 0);
            }

            foreach ($config['controllers'][$controllerKey]['subnav'] as $i => $subnav) {
                data_fill($config, "controllers.{$controllerKey}.subnav.{$i}.href", null);
                data_fill($config, "controllers.{$controllerKey}.subnav.{$i}.icon", null);
                data_fill($config, "controllers.{$controllerKey}.subnav.{$i}.label", null);
                data_fill($config, "controllers.{$controllerKey}.subnav.{$i}.order", null);
                data_fill($config, "controllers.{$controllerKey}.subnav.{$i}.permissions", []);
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

        return $config;
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
     * Get subnav
     *
     * @return array
     */
    public function subnav(string $route): array
    {
        return data_get($this->controller($route), 'subnav', []);
    }

    /**
     * Validate config
     *
     * @return void
     */
    public function validate(): void
    {
        $validator = Validator::make($this->config, [
            'controllers.*.model' => ['present', 'nullable', 'string'],
            'controllers.*.nav' => ['present', 'nullable', 'array'],
            'controllers.*.nav.icon' => ['nullable', 'string'],
            'controllers.*.nav.label' => ['nullable', 'string'],
            'controllers.*.nav.order' => ['int'],
            'controllers.*.nav.permissions' => ['array'],
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
            'controllers.*.subnav.*.order' => ['present', 'int'],
            'controllers.*.subnav.*.permissions' => ['present', 'array'],
        ]);

        if ($validator->fails()) {
            throw new Exception('Invalid backend config: ' . $validator->errors()->first());
        }
    }
}
