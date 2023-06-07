<?php

namespace Tests\Feature\Classes;

use Bedard\Backend\Config\Plugins\Plugin;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HelloPlugin extends Plugin
{
    /**
     * Handle request
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\View\View|array
     */
    public function handle(Request $request): View|array
    {
        return view('backend::tests.hello', [
            'name' => $this->name,
        ]);
    }
}