<?php

namespace Bedard\Backend\Http\Controllers;

use Backend;
use Bedard\Backend\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class BackendController extends Controller
{
    /**
     * Backend single page application
     *
     * @param \Illuminate\Http\Request $request
     */
    public function index(Request $request)
    {
        $user = Auth::getUser();

        return view('backend::index', [
            'context' => json_encode([
                'config' => [],
                'prefix' => config('backend.path'),
                'resources' => [],
                'user' => $user,
            ]),
            'local' => app()->environment('local'),
            'manifest' => $this->manifest(),
        ]);
    }

    /**
     * Get the frontend manifest from Vite.
     *
     * @return array
     */
    private function manifest()
    {
        $manifest = public_path('vendor/backend/dist/manifest.json');

        return json_decode($manifest, true);
    }
}