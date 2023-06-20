<?php

namespace Bedard\Backend\Config\Plugins;

use Bedard\Backend\Config\Config;
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
}
