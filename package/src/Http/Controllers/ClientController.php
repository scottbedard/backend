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
        $manifest = json_decode(File::get(public_path('vendor/backend/dist/manifest.json')), true);

        return view('backend::index', [
            'manifest' => $manifest,
        ]);
    }
}
