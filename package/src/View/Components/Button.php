<?php

namespace Bedard\Backend\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    /**
     * Create a new component instance.
     *
     * @param ?string $icon
     * @param ?string $theme
     *
     * @return void
     */
    public function __construct(
        public ?string $icon = null,
        public ?string $theme = 'default',
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('backend::components.button');
    }
}
