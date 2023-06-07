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
     * Create a new component instance.
     */
    public function __construct(
        public ?string $controller = null,
        public ?string $route = null,
        public bool $padded = false,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $dev = env('BACKEND_DEV');

        $manifest = new ViteManifest(env('BACKEND_MANIFEST_PATH', public_path('vendor/backend/manifest.json')));

        $user = auth()->user();

        $backend = Backend::create(config('backend.backend_directories'));
        
        return view('backend::components.layout', [
            'backend' => $backend,
            'dev' => $dev,
            'logout' => config('backend.logout_href'),
            'manifest' => $manifest,
            'scripts' => $manifest->scripts(),
            'styles' => $manifest->styles(),
        ]);
    }
}
