<?php

namespace Bedard\Backend\View\Components;

use Bedard\Backend\Classes\ViteManifest;
use Bedard\Backend\Facades\Backend;
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

        $nav = Backend::nav($user);

        $route = Backend::route(request()->route()->getName());

        $subnav = $route->controller()->subnav($user);
        
        return view('backend::components.layout', [
            'dev' => $dev,
            'logout' => config('backend.logout_href'),
            'manifest' => $manifest,
            'nav' => $nav,
            'scripts' => $manifest->scripts(),
            'styles' => $manifest->styles(),
            'subnav' => $subnav,
        ]);
    }
}
