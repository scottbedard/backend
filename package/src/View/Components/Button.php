<?php

namespace Bedard\Backend\View\Components;

use Bedard\Backend\Config\Common\Confirmation;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public ?Confirmation $confirmation = null,
        public ?string $href = null,
        public ?string $icon = null,
        public ?string $theme = 'default',
        public ?string $to = null,
        public ?string $type = 'button',
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('backend::components.button');
    }
}
