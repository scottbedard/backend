<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Config;

class Reject extends Config
{
    public function defineBehaviors(): array
    {
        return [
            RejectBehavior::class,
        ];
    }

    public function defineChildren(): array
    {
        return [
            'child' => self::class,
        ];
    }
}
