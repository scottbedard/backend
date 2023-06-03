<?php

namespace Bedard\Backend\Config\Behaviors;

use Bedard\Backend\Config\Behavior;

class Permissions extends Behavior
{
    public function getDefaultPermissionsConfig(): array
    {
        return [];
    }
}