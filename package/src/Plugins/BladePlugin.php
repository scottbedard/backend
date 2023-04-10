<?php

namespace Bedard\Backend\Plugins;

use Bedard\Backend\Classes\Paginator;
use Bedard\Backend\Facades\Backend;
use Bedard\Backend\Plugin;
use Illuminate\View\View;

class BladePlugin extends Plugin
{
    /**
     * Plugin view
     *
     * @return \Illuminate\View\View
     */
    public function view(): View
    {
        $view = data_get($this->route, 'options.view');

        return view($view);
    }
}
