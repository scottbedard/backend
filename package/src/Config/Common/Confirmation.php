<?php

namespace Bedard\Backend\Config\Common;

use Bedard\Backend\Config\Config;

class Confirmation extends Config
{
    /**
     * Define validation rules
     *
     * @return array
     */
    public function defineValidation(): array
    {
        return [
            'confirm' => 'required|string',
            'icon' => 'present|nullable|string',
            'message' => 'required|string',
            'theme' => 'required|in:danger,default,primary,text',
        ];
    }

    /**
     * Get default config
     *
     * @return array
     */
    public function getDefaultConfig(): array
    {
        return [
            'confirm' => 'Confirm',
            'icon' => null,
            'theme' => 'default',
        ];
    }
}
