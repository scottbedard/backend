<?php

namespace Bedard\Backend\Toolbar;

use Bedard\Backend\Exceptions\InvalidThemeException;
use Bedard\Backend\Toolbar\Base;
use Bedard\Backend\Util;

class Button extends Base
{
    /**
     * Attributes
     *
     * @var array
     */
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
     * @param array $context
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render(array $context)
    {
        return view('backend::toolbar.button', [
            'attrs' => $this->attributes,
            'context' => $context,
        ]);
    }

    /**
     * Set confirm
     *
     * @param array $confirm
     *
     * @return void
     */
    public function setConfirmAttribute(array $confirm): void
    {
        $this->attributes['confirm'] = array_merge([
            'buttonText' => 'Confirm',
            'buttonTheme' => 'primary',
            'secondaryIcon' => null,
            'secondaryText' => null,
            'text' => 'Please confirm the action.',
            'title' => 'Are you sure?',
        ], $confirm);
    }

    /**
     * Set theme
     *
     * @return void
     */
    public function setThemeAttribute(string $theme): void
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
