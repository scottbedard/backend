<?php

namespace Bedard\Backend\Config\Plugins;

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
        return view($this->view ?: 'backend::blade-plugin');
    }
}
