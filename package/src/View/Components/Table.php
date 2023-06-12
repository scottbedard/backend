<?php

namespace Bedard\Backend\View\Components;

use Bedard\Backend\Classes\Paginator;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Table extends Component
{
    public function __construct(
        public readonly Collection $columns,
        public readonly Paginator $paginator,
    ) {}

    public function render(): View|Closure|string
    {
        return view('backend::components.table', [
            'columns' => $this->columns,
            'paginator' => $this->paginator,
        ]);
    }
}
