<?php

namespace Bedard\Backend\Config\Plugins;

use Bedard\Backend\Config\Config;
use Bedard\Backend\Config\Route;
use Illuminate\Http\Request;

class Plugin extends Config
{
    public function getDefaultConfig(): array
    {
        return [
            'plugin' => 'blade',
            'options' => [],
        ];
    }

    /**
     * Handle the request
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\View\View|array
     */
    public function handle(Request $request)
    {
        return view('backend::blade-plugin');
    }

    /**
     * Route
     *
     * @return \Bedard\Backend\Config\Route
     */
    public function route()
    {
        return $this->closest(Route::class);
    }
}
