<?php

namespace Bedard\Backend\Classes;

use Illuminate\Support\Facades\Validator;

class Plugin
{
    /**
     * Create a new plugin
     *
     * @param array $params
     */
    public function __construct(array $params)
    {
        $validator = Validator::make($params, [
            'config' => 'required|array',
            'controllers' => 'required|array',
            'name' => 'required|string',
            'route' => 'required|string',
        ]);
        
        if ($validator->fails()) {
            throw new \Exception('Invalid plugin config: ' . $validator->errors()->first());
        }
    }
}
