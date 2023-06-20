<?php

namespace Bedard\Backend\Config\Plugins;

use Bedard\Backend\Config\Behaviors\ToHref;
use Illuminate\Http\Request;

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
