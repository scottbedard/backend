<?php

namespace Bedard\Backend\Plugins;

use Bedard\Backend\Classes\Paginator;
use Bedard\Backend\Facades\Backend;
use Bedard\Backend\Plugin;
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

    /**
     * Plugin view
     *
     * @return \Illuminate\View\View
     */
    public function view(): View
    {
        return view('backend::form', [
            'props' => [
                'options' => $this->route['options'],
            ],
        ]);
    }
}
