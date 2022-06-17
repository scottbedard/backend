<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Components\Block;

class ResourceIndex extends Block
{
    protected function output()
    {
        return view('backend::components.resource-index');
    }
}