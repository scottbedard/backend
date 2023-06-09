<?php

namespace Bedard\Backend\Config\Plugins;

use Bedard\Backend\Config\Backend;
use Bedard\Backend\Config\Config;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FormPlugin extends Plugin
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
        throw new \Exception('Not implemented');
    }
}
