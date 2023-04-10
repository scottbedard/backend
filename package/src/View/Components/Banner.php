<?php

namespace Bedard\Backend\View\Components;

use Bedard\Backend\Classes\ViteManifest;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Banner extends Component
{
    /**
     * Create a new component instance.
     *
     * @param string $name
     *
     * @return void
     */
    public function __construct(
        public string|null $header = null,
        public string|null $icon = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('backend::components.banner');
    }
}
