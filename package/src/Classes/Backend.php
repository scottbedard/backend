<?php

namespace Bedard\Backend\Classes;

use Bedard\Backend\Classes\ViteManifest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Symfony\Component\Yaml\Yaml;

class Backend
{
    /**
     * Check if a user has access to a permission. If no permission
     * is specified, the user will be checked for _any_ backend permission.
     *
     * @param mixed $user
     * @param ?string $permission
     * @return bool
     */
    public function check(mixed $user, ...$permissions): bool
    {
        if (!$user || !is_a($user, config('backend.user'))) {
            return false;
        }

        $super = config('backend.super_admin_role');

        if (count($permissions) === 0) {
            return $user->getAllPermissions()->count() > 0 || $user->hasRole($super);
        }

        return $user->hasAllPermissions(...Arr::flatten($permissions)) || $user->hasRole($super);
    }

    /**
     * Generate backend config
     *
     * @return array
     */
    public function config(): array
    {
        $config = [
            'controllers' => [],
        ];

        // first-party backend
        collect(scandir(__DIR__ . '/../Backend'))
            ->filter(fn ($file) => str_ends_with($file, '.yaml'))
            ->each(function ($file) use (&$config) {
                $name = strtolower(substr($file, 0, -5));

                data_set($config, "controllers.{$name}", Yaml::parseFile(__DIR__ . '/../Backend/' . $file));
            });

        // app backend
        $dir = config('backend.backend_directory');

        if (file_exists($dir)) {
            collect(scandir($dir))
                ->filter(fn ($file) => str_ends_with($file, '.yaml'))
                ->each(function ($file) use (&$config, $dir) {
                    $name = strtolower(substr($file, 0, -5));

                    data_set($config, "controllers.{$name}", Yaml::parseFile($dir . '/' . $file));
                });
        }

        // fill default values
        data_fill($config, 'controllers.*.model', null);
        data_fill($config, 'controllers.*.permissions', []);
        data_fill($config, 'controllers.*.routes', []);
        data_fill($config, 'controllers.*.routes.*.options', []);
        data_fill($config, 'controllers.*.routes.*.permissions', []);

        foreach ($config['controllers'] as $id => $controller) {
            data_fill($config, "controllers.{$id}.id", $id);
        }

        // apply plugin aliases
        $plugins = config('backend.plugins', []);

        foreach ($config['controllers'] as $controllerName => $controller) {
            foreach ($controller['routes'] as $routeName => $route) {
                $pluginName = data_get($route, 'plugin');

                if (array_key_exists($pluginName, $plugins)) {
                    data_set($config, "controllers.{$controllerName}.routes.{$routeName}.plugin", $plugins[$pluginName]);
                }
            }
        }

        dd($config);

        return $config;

        // application backend

        // if (!str_starts_with($routeName, 'backend.')) {
        //     return [];
        // }

        // list($controller, $route) = Str::of($routeName)->ltrim('backend.')->explode('.');
        
        // return data_get($this->controllers(), "{$controller}.routes.{$route}");
    }

    /**
     * Return backend controller data
     *
     * @return array
     */
    public function controllers(): array
    {
        // core backend
        $backend = [];

        collect(scandir(__DIR__ . '/../Backend'))
            ->filter(fn ($file) => str_ends_with($file, '.yaml'))
            ->each(function ($file) use (&$backend) {
                $name = strtolower(substr($file, 0, -5));
                $backend[$name] = Yaml::parseFile(__DIR__ . '/../Backend/' . $file);
            });

        // app backend
        $dir = config('backend.backend_directory');

        if (file_exists($dir)) {
            collect(scandir($dir))
                ->filter(fn ($file) => str_ends_with($file, '.yaml'))
                ->each(function ($file) use (&$backend, $dir) {
                    $name = strtolower(substr($file, 0, -5));
                    $backend[$name] = Yaml::parseFile($dir . '/' . $file);
                });
        }

        // fill default values
        data_fill($backend, '*.class', \Bedard\Backend\BackendController::class);
        data_fill($backend, '*.model', null);
        data_fill($backend, '*.permissions', []);
        data_fill($backend, '*.routes.*.permissions', []);

        $pages = config('backend.pages', []);
        
        foreach ($backend as $controller => $config) {
            // default id to file name
            data_fill($backend, "{$controller}.id", $controller);
            
            // apply page type aliases
            foreach ($config['routes'] as $route => $routeConfig) {
                if (isset($routeConfig['page']) && isset($pages[$routeConfig['page']])) {
                    $backend[$controller]['routes'][$route]['page'] = $pages[$routeConfig['page']];
                }
            }
        }

        // run validation and display errors
        $validator = Validator::make($backend, [
            '*.class' => ['required', 'string'],
            '*.id' => ['required', 'alpha_num:ascii', 'distinct'],
            '*.model' => ['nullable', 'string'],
            '*.permissions' => ['required', 'array'],
            '*.routes.*.plugin' => ['required', 'string'],
        ]);
        
        if ($validator->fails()) {
            throw new \Exception('Invalid backend config: ' . $validator->errors()->first());
        }

        return $backend;
    }

    /**
     * Return a backend view
     *
     * @param array $data
     * @param string $view
     *
     * @return \Illuminate\View\View
     */
    public function view(array $data = [], string $view = ''): View
    {
        $dev = env('BACKEND_DEV');

        $manifest = new ViteManifest(env('BACKEND_MANIFEST_PATH', public_path('vendor/backend/manifest.json')));

        return view('backend::client', [
            'data' => $data,
            'dev' => $dev,
            'manifest' => $manifest,
            'scripts' => $manifest->scripts(),
            'styles' => $manifest->styles(),
            'view' => view($view, [
                'manifest' => $manifest,
            ]),
        ]);
    }
}
