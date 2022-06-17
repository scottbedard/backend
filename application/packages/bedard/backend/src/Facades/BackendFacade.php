<?php

namespace Bedard\Backend\Facades;

use Illuminate\Support\Facades\Facade;

class BackendFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return 'backend';
    }
}
