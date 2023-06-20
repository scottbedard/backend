<?php

namespace Bedard\Backend\Config\Plugins;

use Illuminate\Http\Request;

class FormPlugin extends Plugin
{
    /**
     * Render
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\View\View|array
     */
    public function handle(Request $request)
    {
        throw new \Exception('Not implemented');
    }
}
