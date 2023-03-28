<?php

namespace Bedard\Backend\Classes;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
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
    public function check(mixed $user, ?string $permission = null): bool
    {
        if (!$user || !is_a($user, config('backend.user'))) {
            return false;
        }

        if ($user->hasRole(config('backend.super_admin_role'))) {
            return true;
        }

        if ($permission === null) {
            return $user->permissions()->count() > 0;
        }
    
        return $user->hasPermissionTo($permission);
    }

    /**
     * Get backend config for route
     *
     * @param string $routeName
     *
     * @return array
     */
    public function config(string $routeName): array
    {
        list($controller, $route) = Str::of($routeName)->ltrim('backend.')->explode('.');
        
        return data_get($this->controllers(), "{$controller}.routes.{$route}");
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
            '*.class' => ['required'],
            '*.id' => ['required', 'alpha_num:ascii', 'distinct'],
            '*.permissions' => ['required', 'array'],
            '*.routes.*.page' => ['required', 'string'],
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
     *
     * @return \Illuminate\View\View
     */
    public function view(array $data = []): View
    {
        $dev = env('BACKEND_DEV');

        $manifestPath = env('BACKEND_MANIFEST_PATH', public_path('vendor/backend/manifest.json'));

        $manifest = File::exists($manifestPath)
            ? json_decode(File::get($manifestPath), true)
            : null;

        return view('backend::index', [
            'data' => $data,
            'dev' => $dev,
            'manifest' => $manifest,
        ]);
    }
}
