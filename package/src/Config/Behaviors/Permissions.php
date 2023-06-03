<?php

namespace Bedard\Backend\Config\Behaviors;

use Bedard\Backend\Config\Behavior;

class Permissions extends Behavior
{
    public function getDefaultPermissions(): array
    {
        return [];
    }
}