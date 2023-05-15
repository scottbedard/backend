<?php

namespace Tests\Feature\Classes;

use Bedard\Backend\Configuration\Configuration;

class LazyChild extends Configuration
{
    /**
     * Disable auto-create
     *
     * @var bool
     */
    public static bool $autocreate = false;
}
