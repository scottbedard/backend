<?php

namespace Bedard\Backend\Classes;

use Bedard\Backend\BackendController;
use Bedard\Backend\Classes\UrlPath;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
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
     * Return the controller for a request
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Support\Collection
     */
    public function controllers(): Collection
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

        // @todo: fill default values

        // run validation and display errors
        $validator = Validator::make($backend, [
            '*.class' => 'required',
            '*.name' => 'required',
        ]);
        
        if ($validator->fails()) {
            throw new \Exception('Invalid backend config: ' . $validator->errors()->first());
        }

        return collect($backend)->map(fn ($ctrl) => new $ctrl['class']($ctrl));
    }
}
