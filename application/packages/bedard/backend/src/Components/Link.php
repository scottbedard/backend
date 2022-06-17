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
        'toRoute' => null,
    ];

    /**
     * Render
     *
     * @return \Illuminate\View\View|string
     */
    protected function output()
    {
        return view('backend::renderables.link', $this->attributes);
    }
}