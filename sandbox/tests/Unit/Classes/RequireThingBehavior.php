<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Behavior;

class RequireThingBehavior extends Behavior
{
    public function defineValidation(): array
    {
        return [
            'thing' => 'required',
        ];
    }
}
