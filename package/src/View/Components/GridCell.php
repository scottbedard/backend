<?php

namespace Bedard\Backend\View\Components;

use Bedard\Backend\Classes\Breakpoint;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GridCell extends Component
{
    /**
     * Create a new component instance.
     *
     * @param  array|int  $span
     *
     * @return void
     */
    public function __construct(
        public array|int $span = 12,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $span = Breakpoint::create($this->span);

        return view('backend::components.grid-cell', [
            'span' => $span,
        ]);
    }
}
