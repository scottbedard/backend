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
     * @param \Illuminate\Http\Request $request
     * @param \Bedard\Backend\Configuration\Route $route
     *
     * @return \Illuminate\View\View
     */
    public function render(Request $request, Route $route): View
    {
        return view('backend::missing-plugin');
    }
}