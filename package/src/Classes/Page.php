<?php

namespace Bedard\Backend\Classes;

use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class Page
{
    /**
     * Vite manifest
     *
     * @return array
     */
    public static function manifest(): array
    {
        $manifest = env('BACKEND_MANIFEST_PATH', public_path('vendor/backend/manifest.json'));

        return File::exists($manifest) ? json_decode(File::get($manifest), true) : null;
    }

    /**
     * Return a backend view
     *
     * @param array $data
     *
     * @return \Illuminate\View\View
     */
    public static function view(array $data = [])
    {
        $dev = env('BACKEND_DEV');
        $manifest = self::manifest();

        return view('backend::index', [
            'data' => $data,
            'dev' => $dev,
            'manifest' => $manifest,
        ]);
    }
}
