<?php

namespace Bedard\Backend\Classes;

use Bedard\Backend\Classes\ViteManifest;
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
    private array $config;

    /**
     * Create backend instance
     *
     * @return void
     */
    public function __construct()
    {
        // collect namespaced data
        $this->config = ['controllers' => []];

        $read = fn ($dir) => collect(scandir($dir))
            ->filter(fn ($file) => !str_starts_with($file, '_') && str_ends_with($file, '.yaml'))
            ->each(function ($file) use ($dir) {
                $key = str($file)->lower()->rtrim('.yaml')->kebab()->toString();

                $this->config['controllers'][$key] = Yaml::parseFile($dir . '/' . $file);
            });

        $read(__DIR__ . '/../Backend');

        $dir = config('backend.backend_directory');

        if ($dir) {
            $read($dir);
        }

        // collect root data, use default if none is present
        $root = File::exists("{$dir}/_root.yaml")
            ? "{$dir}/_root.yaml"
            : __DIR__ . '/../Backend/_root.yaml';

        $this->config['controllers']['_root'] = Yaml::parseFile($root);
        
        // fill defaults
        data_fill($this->config, 'controllers.*.model', null);
        data_fill($this->config, 'controllers.*.nav', null);
        data_fill($this->config, 'controllers.*.nav.order', 0);
        data_fill($this->config, 'controllers.*.permissions', []);
        data_fill($this->config, 'controllers.*.routes', []);
        data_fill($this->config, 'controllers.*.routes.*.options', []);
        data_fill($this->config, 'controllers.*.routes.*.permissions', []);
        data_fill($this->config, 'controllers.*.sidenav', []);

        foreach ($this->config['controllers'] as $controller => $c) {
            data_fill($this->config, "controllers.{$controller}.id", $controller);
            data_fill($this->config, "controllers.{$controller}.routes.*.model", $c['model']);

            if (data_get($this->config, "controllers.{$controller}.nav")) {
                $namespace = $controller === '_root' ? '' : $controller;
                $backend = str(config('backend.path', ''))->trim('/');
                $href = rtrim("/{$backend}/{$namespace}", '/');

                data_fill($this->config, "controllers.{$controller}.nav.href", $href);
            }
        }

        // apply aliases
        foreach ($this->config['controllers'] as $controller => $c) {
            foreach ($c['routes'] as $route => $r) {
                $plugin = data_get(config('backend.plugins', []), data_get($r, 'plugin'));

                if ($plugin) {
                    data_set($this->config, "controllers.{$controller}.routes.{$route}.plugin", $plugin);
                }
            }
        }
        
        // validate config
        $validator = Validator::make($this->config, [
            'controllers.*.id' => ['present', 'string'],
            'controllers.*.model' => ['present', 'nullable', 'string'],
            'controllers.*.nav' => ['present', 'nullable'],
            'controllers.*.nav.href' => ['string'],
            'controllers.*.nav.icon' => ['string'],
            'controllers.*.nav.label' => ['string'],
            'controllers.*.nav.order' => ['integer'],
            'controllers.*.permissions' => ['present', 'array'],
            'controllers.*.permissions.*' => ['string'],
            'controllers.*.routes' => ['present', 'array'],
            'controllers.*.routes.*.model' => ['present', 'nullable', 'string'],
            'controllers.*.routes.*.options' => ['present', 'array'],
            'controllers.*.routes.*.permissions' => ['present', 'array'],
            'controllers.*.routes.*.permissions.*' => ['string'],
            'controllers.*.sidenav' => ['present', 'array'],
        ]);

        if ($validator->fails()) {
            throw new Exception('Invalid backend config: ' . $validator->errors()->first());
        }
    }

    /**
     * Get backend config
     *
     * @return array
     */
    public function config(): array
    {
        return $this->config;
    }

    /**
     * Get controller definition
     *
     * @param string $route
     *
     * @return array
     */
    public function controller(string $route): array
    {
        if (str($route)->is('backend.*.*')) {
            [, $controllerId] = str($route)->explode('.');
            
            return data_get($this->config, "controllers.{$controllerId}");
        }

        if (str($route)->is('backend.*')) {
            $controllerId = '_root';
            
            return data_get($this->config, "controllers._root.{$controllerId}");
        }
        
        throw new Exception('Backend controller not found: ' . $controllerId);
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
     * Get all sidenav items
     *
     * @return array
     */
    public function sidenav(string $route): array
    {
        return data_get($this->controller($route), 'sidenav', []);
    }
}
