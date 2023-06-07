<?php

namespace Bedard\Backend\Config\Plugins;

use Bedard\Backend\Config\Config;
use Illuminate\View\View;

class Plugin extends Config
{
    /**
     * Render
     *
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('backend::missing-plugin');
    }
}