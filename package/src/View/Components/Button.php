<?php

namespace Bedard\Backend\View\Components;

use Bedard\Backend\Classes\To;
use Bedard\Backend\Config\Backend;
use Bedard\Backend\Config\Controller;
use Bedard\Backend\Config\Route;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    /**
     * Create a new component instance.
     *
     * @param  ?string  $href
     * @param  ?string  $icon
     * @param  ?string  $theme
     *
     * @return void
     */
    public function __construct(
        public ?string $href = null,
        public ?string $icon = null,
        public ?string $theme = 'default',
        public ?string $to = null,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $href = '';
        $theme = $this->theme;

        return view('backend::components.button', [
            'href' => $href,
            'theme' => $theme,
        ]);
    }
}
