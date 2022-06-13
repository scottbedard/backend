<?php

namespace Bedard\Backend\Components;

use Backend;

use Bedard\Backend\Components\Block;

class Link extends Block
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'href' => '#',
        'iconLeft' => null,
        'iconRight' => null,
        'text' => '',
    ];

    /**
     * Render
     *
     * @return \Illuminate\View\View|string
     */
    protected function output()
    {
        return view('backend::renderables.link', [
            'href' => $this->href,
            'iconLeft' => $this->iconLeft,
            'iconRight' => $this->iconRight,
            'text' => $this->text,
        ]);
    }
}