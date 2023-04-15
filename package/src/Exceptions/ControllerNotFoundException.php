<?php

namespace Bedard\Backend\Exceptions;

class ControllerNotFoundException extends Exception
{
    public function __construct(string $controller)
    {
        parent::__construct("Backend controller [{$controller}] not found.");
    }
}
