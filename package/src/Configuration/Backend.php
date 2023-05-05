<?php

namespace Bedard\Backend\Configuration;

use Bedard\Backend\Classes\KeyedArray;
use Bedard\Backend\Exceptions\ConfigurationException;
use Illuminate\Support\Facades\File;
use Symfony\Component\Yaml\Yaml;

class Backend extends Configuration
{
    /**
     * Default
     *
     * @var array
     */
    public array $default = [
        'controllers' => [],
    ];

    /**
     * Properties
     *
     * @var array
     */
    public array $props = [
        'controllers' => [Controller::class, 'path'],
    ];

    /**
     * Rules
     * 
     * @var array
     */
    public array $rules = [
        'controllers.*.id' => 'required|distinct',
    ];

    /**
     * Create a backend
     *
     * @param array $targets
     */
    public function __construct(...$files)
    {
        // read yaml files and build config
        $controllers = [];

        $parse = function (string $path) use (&$controllers, &$parse) {
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

                $controllers[$key] = Yaml::parseFile($path) ?? [];
            }
        };

        collect($files)->flatten()->each($parse);
        
        parent::__construct([
            'controllers' => KeyedArray::from($controllers, 'id'),
        ]);
    }

    /**
     * Get controller by ID
     *
     * @param string $id
     *
     * @return ?Bedard\Backend\Configuration\Configuration
     */
    public function controller(string $id): ?Configuration
    {
        return $this->get('controllers')->first(fn ($item) => $item->get('id') === $id);
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

            $route = $this
                ->controller($controllerId)
                ->get('routes')
                ->first(fn ($r) => $r['id'] === $routeId);

            $obj = $this->get("controllers.{$controllerId}.routes.{$routeId}");

            if ($obj) {
                return $obj;
            }
        }

        elseif (str($route)->is('backend.*')) {
            $controllerId = '_root';

            $routeId = str($route)->explode('.')->last();

            $obj = $this->get("controllers.{$controllerId}.routes.{$routeId}");

            if ($obj) {
                return $obj;
            }
        }
        
        throw new ConfigurationException('Backend route not found: ' . $route);
    }
}
