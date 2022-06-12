<?php

namespace Bedard\Backend\Components;

class Field extends Component
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        // ...
    ];

    /**
     * Render
     *
     * @return \Illuminate\View\View|string|callable
     */
    public function render()
    {
        return 'hello';
    }
}
