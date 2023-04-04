<?php

namespace Bedard\Backend\Plugins;

use Bedard\Backend\Classes\Plugin;
use Bedard\Backend\Facades\Backend;
use Illuminate\View\View;

class ListPlugin extends Plugin
{
    /**
     * Plugin data
     *
     * @return array
     */
    public function data(): array
    {
        $model = $this->controller['model'];

        $items = $model::query()->paginate(20);

        return [
            'config' => $this->config,
            'data' => $items
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
            view: 'backend::list', 
        );
    }
}
