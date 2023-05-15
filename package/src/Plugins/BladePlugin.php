<?php

namespace Bedard\Backend\Plugins;

use Illuminate\View\View;

class BladePlugin extends Plugin
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