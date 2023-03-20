<?php

namespace Bedard\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class ClientController extends Controller
{
    /**
     * Backend single page application.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $manifest = env('BACKEND_MANIFEST_PATH', public_path('vendor/backend/dist/manifest.json'));

        $spatie = in_array(\Spatie\Permission\PermissionServiceProvider::class, config('app.providers'));

        return view('backend::index', [
            'dev' => env('BACKEND_DEV'),
            'manifest' => File::exists($manifest) ? json_decode(File::get($manifest), true) : null,
            'spatie' => $spatie,
        ]);
    }
}
