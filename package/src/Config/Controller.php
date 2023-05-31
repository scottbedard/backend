<?php

namespace Bedard\Backend\Config;

class Controller extends Config
{
    /**
     * Define child config
     *
     * @return array
     */
    public function defineChildren(): array
    {
        return [
            'nav' => [Nav::class],
        ];
    }
}
