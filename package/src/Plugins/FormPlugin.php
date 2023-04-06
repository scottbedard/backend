<?php

namespace Bedard\Backend\Plugins;

use Bedard\Backend\Classes\Paginator;
use Bedard\Backend\Classes\Plugin;
use Bedard\Backend\Facades\Backend;
use Illuminate\View\View;

class FormPlugin extends Plugin
{
    /**
     * Plugin data
     *
     * @return array
     */
    public function data(): array
    {
        return [];
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
            view: 'backend::form', 
        );
    }

    /**
     * Validate config
     *
     * @throws Exception
     */
    public function validate(): void
    {
        // $validator = Validator::make($this->config, [
        //     // ...
        // ]);
        
        // if ($validator->fails()) {
        //     throw new \Exception('Invalid plugin config: ' . $validator->errors()->first());
        // }
    }
}
