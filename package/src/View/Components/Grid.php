<?php

namespace Bedard\Backend\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Grid extends Component
{
    /**
     * Create a new component instance.
     *
     * @param int $cols
     *
     * @return void
     */
    public function __construct(
        public bool $padded = false,
        public int $cols = 12,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('backend::components.grid');
    }
}
