<?php

namespace Bedard\Backend\Facades;

use Illuminate\Support\Facades\Facade;

class Backend extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'backend';
    }
}