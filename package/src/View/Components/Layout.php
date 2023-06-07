<?php

namespace Bedard\Backend\View\Components;

use Bedard\Backend\Classes\ViteManifest;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Layout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public bool $padded = false,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $dev = env('BACKEND_DEV');

        $manifest = new ViteManifest(env('BACKEND_MANIFEST_PATH', public_path('vendor/backend/manifest.json')));

        $user = auth()->user();

        // dd('ctrl', request()->route('controller'), request()->route('route'));

        $nav = []; //Backend::nav($user);

        $route = []; //Backend::route(request()->route()->getName());

        $subnav = []; //$route->controller()->subnav($user);

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
