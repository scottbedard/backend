<?php

namespace Bedard\Backend\Views\Components;

use Bedard\Backend\Util;
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
                    "<svg data-icon {$data['attributes']->toHtml()}",
                ], File::get($path), 1);

                return $svg;
            } catch (FileNotFoundException $e) {
                $suggestion = Util::suggest($this->name, array_map(function ($file) {
                    return substr($file->getFilename(), 0, -4);
                }, File::allFiles(($dir))));

                throw new FileNotFoundException("Unknown icon \"{$this->name}\", did you mean \"{$suggestion}\"?");
            }  
        };
    }
}
