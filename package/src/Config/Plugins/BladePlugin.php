<?php

namespace Bedard\Backend\Config\Plugins;

use Bedard\Backend\Config\Config;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BladePlugin extends Plugin
{
    /**
     * Render
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\View\View|array
     */
    public function handle(Request $request): View|array
    {
        return view('backend::blade-plugin');
    }
}