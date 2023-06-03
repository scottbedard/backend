<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Behavior;
use Bedard\Backend\Config\Config;
use Bedard\Backend\Exceptions\RejectConfigException;

class RequireThingBehavior extends Behavior
{
    public function defineValidation(): array
    {
        return [
            'thing' => 'required',
        ];
    }
}
