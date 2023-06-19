<?php

namespace Bedard\Backend\Config\Plugins;

use Bedard\Backend\Classes\To;
use Bedard\Backend\Config\Backend;
use Bedard\Backend\Config\Behaviors\ToHref;
use Bedard\Backend\Config\Config;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RedirectPlugin extends Plugin
{
    /**
     * Define behaviors
     *
     * @return array
     */
    public function defineBehaviors(): array
    {
        return [
            ToHref::class,
        ];
    }

    /**
     * Handle the request
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\View\View|array
     */
    public function handle(Request $request)
    {
        return redirect($this->href);
    }
}
