<?php

namespace Bedard\Backend\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GridCell extends Component
{
    /**
     * Create a new component instance.
     *
     * @param  array  $span
     *
     * @return void
     */
    public function __construct(
        public array $span = [],
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('backend::components.grid-cell');
    }
}
