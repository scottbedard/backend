<?php

namespace Bedard\Backend\Http\Controllers;

use Backend;
use Bedard\Backend\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Js;

class BackendController extends Controller
{
    /**
     * Backend single page application
     *
     * @param \Illuminate\Http\Request $request
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect(config('backend.guest_redirect'));
        }
        
        return view('backend::index', [
            'context' => $this->context(),
            'local' => (bool) app()->environment('local'),
            'manifest' => $this->manifest(),
        ]);
    }

    /**
     * Get frontend context. This will be exposed to the view under `window.context`.
     *
     * @return string
     */
    private function context()
    {
        $context = [
            'config' => [],
            'path' => config('backend.path'),
            'resources' => Backend::resources(),
            'user' => Auth::getUser(),
        ];

        return Js::from($context);
    }

    /**
     * Get the frontend manifest from Vite.
     *
     * @return array
     */
    private function manifest()
    {
        $manifest = public_path('vendor/backend/dist/manifest.json');

        return json_decode(File::get($manifest), true);
    }
}