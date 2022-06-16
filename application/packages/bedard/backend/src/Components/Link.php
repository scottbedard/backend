<?php

namespace Bedard\Backend\Components;

class Link extends Group
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