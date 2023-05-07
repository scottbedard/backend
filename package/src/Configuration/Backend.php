<?php

namespace Bedard\Backend\Configuration;

use Bedard\Backend\Classes\KeyedArray;
use Bedard\Backend\Exceptions\ConfigurationException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Symfony\Component\Yaml\Yaml;

class Backend extends Configuration
{
    /**
     * Default data
     *
     * @var array
     */
    public array $defaults = [
        'controllers' => [],
    ];

    /**
     * Child properties
     *
     * @var array
     */
    public array $props = [
        'controllers' => [Controller::class, 'path'],
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public array $rules = [
        'controllers.*.id' => 'required|distinct',
    ];

    /**
     * Construct
     *
     * @param array $files
     */
    public function __construct(...$files)
    {
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
        return $this->controllers()->first(fn ($item) => $item->get('id') === $id);
    }

    /**
     * Get all controllers
     *
     * @return Illuminate\Support\Collection
     */
    public function controllers(): Collection
    {
        return $this->get('controllers');
    }

    /**
     * Get route definition
     *
     * @param string $route
     *
     * @return Bedard\Backend\Configuration\Route
     */
    public function route(string $route): Route
    {
        if (str($route)->is('backend.*.*')) {
            [, $controllerId, $routeId] = str($route)->explode('.');

            $controller = $this->controller($controllerId);

            if ($controller) {
                $route = $controller
                    ->get('routes')
                    ->first(fn ($r) => $r->get('id') === $routeId);
                
                if ($route) {
                    return $route;
                }
            }
        }
        
        throw new ConfigurationException('Backend route not found: ' . $route);
    }
}