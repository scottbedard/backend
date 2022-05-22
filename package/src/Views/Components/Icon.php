<?php

namespace Bedard\Backend\Views\Components;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Illuminate\View\Component;

class Icon extends Component
{
    public $name;

    public $size;

    public $strokeWidth;
    
    public function __construct(string $name, string|float $size = 24, string|float $strokeWidth = 2)
    {
        $this->name = $name;
        $this->size = $size;
        $this->strokeWidth = $strokeWidth;
    }

    public function render()
    {
        return function ($data)
        {
            $dir = __DIR__ . '/../../../resources/icons/';

            $path = $dir . $this->name . '.svg';

            try {
                $svg = preg_replace([
                    '/[^-]height="\d+"/',
                    '/[^-]width="\d+"/',
                    '/stroke-width="\d+"/',
                    '/^<svg /',
                ], [
                    "height=\"{$this->size}\"",
                    "width=\"{$this->size}\"",
                    "stroke-width=\"{$this->strokeWidth}\"",
                    "<svg {$data['attributes']->toHtml()}",
                ], File::get($path));

                return $svg;
            } catch (FileNotFoundException $e) {
                $closest = null;
                $closestDistance = INF;

                foreach (File::allFiles($dir) as $file) {
                    $icon = substr($file->getFilename(), 0, -4);
                    $distance = levenshtein($this->name, $icon);

                    if ($distance < $closestDistance) {
                        $closest = $icon;
                        $closestDistance = $distance;
                    }
                }

                collect(File::allFiles($dir))->each(function ($file) use (&$closest, &$closestDistance) {
                    $icon = substr($file->getFilename(), 0, -4);
                    $distance = levenshtein($this->name, $icon);

                    if ($distance < $closestDistance) {
                        $closest = $icon;
                        $closestDistance = $distance;
                    }
                });

                throw new FileNotFoundException("Unknown icon \"{$this->name}\", did you mean \"{$closest}\"?");
            }  
        };
    }
}
