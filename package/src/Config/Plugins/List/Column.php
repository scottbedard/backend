<?php

namespace Bedard\Backend\Config\Plugins\List;

use Bedard\Backend\Config\Config;
use Illuminate\Http\Request;
use Illuminate\View\View;

class Column extends Config
{
    /**
     * Define validation rules
     *
     * @return array
     */
    public function defineValidation(): array
    {
        return [
            'label' => ['present', 'nullable', 'string'],
            'id' => ['required', 'nullable', 'string'],
            'type' => ['required', 'string', 'in:blade,date,text,timeago'],
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
            'id' => null,
            'label' => null,
            'span' => 12,
            'type' => 'blade',
        ];
    }
}
