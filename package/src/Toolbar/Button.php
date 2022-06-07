<?php

namespace Bedard\Backend\Toolbar;

use Bedard\Backend\Exceptions\InvalidThemeException;
use Bedard\Backend\Toolbar\Base;
use Bedard\Backend\Util;

class Button extends Base
{
    protected $attributes = [
        'confirm' => null,
        'icon' => null,
        'method' => null,
        'requireSelection' => false,
        'text' => null,
        'theme' => null,
        'to' => '#',
    ];

    /**
     * Render
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('backend::toolbar.button', $this->attributes);
    }

    /**
     * Set theme
     *
     * @return \Bedard\Backend\Toolbar\Base
     */
    public function setThemeAttribute(string $theme)
    {
        $themes = [
            'danger',
            'default',
            'primary',
        ];

        if (!in_array($theme, $themes)) {
            $suggestion = Util::suggest($theme, $themes);

            throw new InvalidThemeException("Unknown button theme \"{$theme}\", did you mean \"{$suggestion}\"?");
        }

        $this->attributes['theme'] = $theme;
    }
}
