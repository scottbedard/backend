<?php

namespace Bedard\Backend\Config;

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
            }

            elseif (File::isFile($path)) {
                $key = str($path)
                    ->lower()
                    ->rtrim('.yaml')
                    ->explode('/')
                    ->last();

                $controllers[$key] = Yaml::parseFile($path) ?? [];
            }
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
                    : str($key)->slug()->toString();
            }
        }
        
        parent::__construct([
            'controllers' => $controllers,
        ]);

        $this->validate();
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
            ->flatten()
            ->sortBy('order')
            ->values();
    }
}