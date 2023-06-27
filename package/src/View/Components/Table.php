<?php

namespace Bedard\Backend\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Table extends Component
{
    public function __construct(
        public readonly Collection $columns,
        public readonly LengthAwarePaginator $paginator,
        public readonly array $hrefs,
    ) { }

    public function render(): View|Closure|string
    {
        $this->paginator->withQueryString();

        $pageUrl = fn (int $p) => urldecode(url()->current() . '?' . http_build_query(array_merge(request()->except('page'), ['page' => $p])));
        
        return view('backend::components.table', [
            'columns' => $this->columns,
            'hrefs' => $this->hrefs,
            'pageUrl' => $pageUrl,
            'paginator' => $this->paginator,
        ]);
    }
}
