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
        $manifest = public_path('vendor/backend/dist/manifest.json');

        return view('backend::index', [
            'manifest' => File::exists($manifest) ? json_decode(File::get($manifest), true) : null,
        ]);
    }
}
