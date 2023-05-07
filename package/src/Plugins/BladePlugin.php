<?php

namespace Bedard\Backend\Plugins;

use Bedard\Backend\Configuration\Route;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BladePlugin extends Plugin
{
    /**
     * Render a plugin.
     *
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('backend::missing-plugin');
    }
}