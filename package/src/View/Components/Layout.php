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
    protected ?string $controller;

    protected ?string $route;

    protected bool $padded;

    public function __construct(?string $controller = null, ?string $route = null, bool $padded = false)
    {
        if ($controller && !$route) {
            $route = $controller;

            $controller = null;
        }

        $this->controller = $controller;

        $this->route = $route;

        $this->padded = $padded;
    }

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
            'controller' => $this->controller,
            'dev' => $dev,
            'logout' => config('backend.logout_href'),
            'manifest' => $manifest,
            'padded' => $this->padded,
            'route' => $this->route,
            'scripts' => $manifest->scripts(),
            'styles' => $manifest->styles(),
        ]);
    }
}
