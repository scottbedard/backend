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
        $routeName = request()->route()->getName();

        $config = Backend::config();
        
        $dev = env('BACKEND_DEV');
        
        $manifest = new ViteManifest(env('BACKEND_MANIFEST_PATH', public_path('vendor/backend/manifest.json')));
        
        $user = auth()->user();

        // build navigation
        $nav = [];

        foreach ($config['controllers'] as $controller) {
            $controllerNav = data_get($controller, 'nav');

            if (!$controllerNav) continue;
            
            foreach ($controller['permissions'] as $permission) {
                try { 
                    if (!$user->hasPermissionTo($permission)) continue 2;
                } catch (PermissionDoesNotExist $e) { }
            }

            array_push($nav, $controllerNav);
        }

        $orderedNav = array_values(Arr::sort($nav, fn ($arr) => $arr['order']));

        $sidenav = Backend::sidenav($routeName);
        
        return view('backend::components.layout', [
            'dev' => $dev,
            'manifest' => $manifest,
            'nav' => $orderedNav,
            'sidenav' => $sidenav,
            'scripts' => $manifest->scripts(),
            'styles' => $manifest->styles(),
        ]);
    }
}
