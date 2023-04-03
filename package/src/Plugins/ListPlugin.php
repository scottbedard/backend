<?php

namespace Bedard\Backend\Plugins;

use Bedard\Backend\Classes\Plugin;
use Illuminate\View\View;

class ListPlugin extends Plugin
{
    /**
     * Render the plugin
     *
     * @return Illuminate\View\View
     */
    public function render(): View
    {
        return view('backend::list');
    }
}
