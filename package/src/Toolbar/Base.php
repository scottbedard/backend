<?php

namespace Bedard\Backend\Toolbar;

use Bedard\Backend\Classes\Fluent;

class Base extends Fluent
{
    /**
     * Required permissions
     *
     * @var array
     */
    public array $permissions = [];

    /**
     * Render
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return '';
    }
}
