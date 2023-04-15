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
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $dev = env('BACKEND_DEV');

        $manifest = new ViteManifest(env('BACKEND_MANIFEST_PATH', public_path('vendor/backend/manifest.json')));

        $routeName = request()->route()->getName();

        $user = auth()->user();

        $nav = Backend::nav($user);

        $subnav = Backend::subnav($routeName, $user);
        
        return view('backend::components.layout', [
            'dev' => $dev,
            'manifest' => $manifest,
            'nav' => $nav,
            'scripts' => $manifest->scripts(),
            'styles' => $manifest->styles(),
            'subnav' => $subnav,
        ]);
    }
}
