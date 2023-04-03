<?php

namespace Bedard\Backend\Plugins;

use Bedard\Backend\Classes\Plugin;
use Bedard\Backend\Facades\Backend;
use Illuminate\View\View;

class ListPlugin extends Plugin
{
    public function data(): array
    {
        return [
            'hello' => 'world again',
        ];
    }

    /**
     * Render the plugin
     *
     * @return Illuminate\View\View
     */
    public function render(): View
    {
        $data = $this->data();

        return Backend::view(
            data: $data,
            view: view('backend::list'),
        );
    }
}
