<?php

namespace Bedard\Backend\View\Components;

use Bedard\Backend\Classes\ViteManifest;
use Bedard\Backend\Config\Backend;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\View\Component;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

class Layout extends Component
{
    /**
     * Construct
     *
     * @param ?bool $padded
     */
    public function __construct(
        public bool $padded = false,
    ) {}

    /**
     * Render
     *
     * @return \Illuminate\Contracts\View\View|Closure|string
     */
    public function render(): View|Closure|string
    {
        $dev = env('BACKEND_DEV');

        $manifest = new ViteManifest(env('BACKEND_MANIFEST_PATH', public_path('vendor/backend/manifest.json')));

        $backend = Backend::create(config('backend.backend_directories'));
        
        return view('backend::components.layout', [
            'backend' => $backend,
            'dev' => $dev,
            'manifest' => $manifest,
            'scripts' => $manifest->scripts(),
            'styles' => $manifest->styles(),
        ]);
    }
}
