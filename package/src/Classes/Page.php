<?php

namespace Bedard\Backend\Classes;

class Page
{
    /**
     * Vite manifest
     *
     * @return array
     */
    public static function manifest(): array
    {
        return env('BACKEND_MANIFEST_PATH', public_path('vendor/backend/manifest.json'));
    }
}
