<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Exceptions\InvalidAttributeException;
use Bedard\Backend\Util;

class Toolbar extends Block
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'align' => 'left',
        'data' => [],
    ];

    /**
     * Render
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('backend::renderables.toolbar', [
            'align' => $this->align,
            'data' => $this->data,
            'items' => $this->items,
        ]);
    }

    /**
     * Set align
     *
     * @param string $align
     *
     * @throws \Bedard\Backend\Exceptions\InvalidAttributeException
     *
     * @return void
     */
    public function setAlignAttribute(string $value)
    {
        $alignments = ['left', 'right', 'center'];

        if (!in_array($value, $alignments)) {
            $suggestion = Util::suggest($value, $alignments);

            throw new InvalidAttributeException("Unknown toolbar alignment \"{$value}\", did you mean \"{$suggestion}\"?");
        }

        $this->attributes['align'] = $value;
    }
}