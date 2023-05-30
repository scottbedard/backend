<?php

namespace Bedard\Backend\Config;

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
    public function getValidationRules(): array
    {
        return [
            'controllers.*.id' => ['distinct', 'required', 'string'],
        ];
    }
}