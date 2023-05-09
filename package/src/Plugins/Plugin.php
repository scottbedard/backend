<?php

namespace Bedard\Backend\Plugins;

use Bedard\Backend\Configuration\Configuration;
use Bedard\Backend\Configuration\Controller;
use Bedard\Backend\Configuration\Route;
use Illuminate\Http\Request;
use Illuminate\View\View;

class Plugin extends Configuration
{
    /**
     * Get a plugin's controller
     *
     * @return \Bedard\Backend\Configuration\Controller
     */
    public function controller()
    {
        return $this->closest(Controller::class);
    }

    /**
     * Render
     *
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('backend::missing-plugin');
    }

    /**
     * Get a plugin's route
     *
     * @return \Bedard\Backend\Configuration\Route
     */
    public function route()
    {
        return $this->closest(Route::class);
    }
}