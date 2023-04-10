<?php

namespace Bedard\Backend\Classes;

use Bedard\Backend\Classes\ViteManifest;
use Exception;
use Illuminate\Support\Arr;
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
        // collect yaml data
        $this->config = ['controllers' => []];

        $read = fn ($dir) => collect(scandir($dir))
            ->filter(fn ($file) => str_ends_with($file, '.yaml'))
            ->each(function ($file) use ($dir) {
                $key = str($file)->lower()->rtrim('.yaml')->kebab()->toString();

                $this->config['controllers'][$key] = Yaml::parseFile($dir . '/' . $file);
            });

        $read(__DIR__ . '/../Backend');

        $read(config('backend.backend_directory'));
        
        // fill defaults
        data_fill($this->config, 'controllers.*.model', null);
        data_fill($this->config, 'controllers.*.nav', null);
        data_fill($this->config, 'controllers.*.permissions', []);
        data_fill($this->config, 'controllers.*.routes', []);
        data_fill($this->config, 'controllers.*.routes.*.options', []);
        data_fill($this->config, 'controllers.*.routes.*.permissions', []);

        foreach ($this->config['controllers'] as $controller => $c) {
            data_fill($this->config, "controllers.{$controller}.id", $controller);

            if (data_get($this->config, "controllers.{$controller}.nav")) {
                data_fill($this->config, "controllers.{$controller}.nav.href", '/' . trim(config('backend.path'), '/') . '/' . $controller);
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

            if ($controller === '_root') {
                data_set($this->config, 'controllers._root.nav.href', str(data_get($c, 'nav.href'))->replace('/_root', ''));
            }
        }
        
        // validate config
        $validator = Validator::make($this->config, [
            'controllers.*.id' => ['present', 'string'],
            'controllers.*.model' => ['present', 'nullable', 'string'],
            'controllers.*.permissions' => ['present', 'array'],
            'controllers.*.permissions.*' => ['string'],
            'controllers.*.routes' => ['present', 'array'],
            'controllers.*.routes.*.options' => ['present', 'array'],
            'controllers.*.routes.*.permissions' => ['present', 'array'],
            'controllers.*.routes.*.permissions.*' => ['string'],
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
            
            return data_get($this->config, "controllers.{$controllerId}");
        }
        
        throw new Exception('Backend controller not found: ' . $controllerId);
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
}
