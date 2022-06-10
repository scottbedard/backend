<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Components\Block;

class ResourceIndex extends Block
{
    public function render()
    {
        return view('backend::components.resource-index');
    }
}