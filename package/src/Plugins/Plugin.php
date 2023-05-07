<?php

namespace Bedard\Backend\Plugins;

use Bedard\Backend\Configuration\Configuration;
use Bedard\Backend\Configuration\Route;
use Illuminate\Http\Request;
use Illuminate\View\View;

class Plugin extends Configuration
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