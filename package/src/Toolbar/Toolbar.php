<?php

namespace Bedard\Backend;

use Bedard\Backend\Classes\Fluent;

class Toolbar extends Fluent
{
    /**
     * Permissions required to access the toolbar item.
     *
     * @var array
     */
    public array $permissions = [];
}
