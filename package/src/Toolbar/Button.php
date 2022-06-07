<?php

namespace Bedard\Backend\Toolbar;

use Bedard\Backend\Exceptions\InvalidThemeException;
use Bedard\Backend\Toolbar\Base;
use Bedard\Backend\Util;

class Button extends Base
{
    /**
     * Confirmation modal
     *
     * @var ?array
     */
    public ?array $confirmation = null;

    /**
     * Method
     *
     * @var ?string
     */
    public ?string $method = null;

    /**
     * Icon
     *
     * @var ?string
     */
    public ?string $icon = null;

    /**
     * Text
     *
     * @var string
     */
    public string $text = '';

    /**
     * Theme
     *
     * @var ?string
     */
    public ?string $theme = null;

    /**
     * To
     *
     * @var string|callable
     */
    public $to = '#';

    /**
     * Render
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('backend::toolbar.button', [
            'confirmation' => $this->confirmation,
            'icon' => $this->icon,
            'method' => $this->method,
            'text' => $this->text,
            'theme' => $this->theme,
        ]);
    }

    // /**
    //  * Set theme
    //  *
    //  * @return \Bedard\Backend\Toolbar\Base
    //  */
    // public function theme(string $theme)
    // {
    //     $themes = [
    //         'danger',
    //         'default',
    //         'primary',
    //     ];

    //     if (!in_array($theme, $themes)) {
    //         $suggestion = Util::suggest($theme, $themes);

    //         throw new InvalidThemeException("Unknown button theme \"{$theme}\", did you mean \"{$suggestion}\"?");
    //     }

    //     $this->theme = $theme;

    //     return $this;
    // }
}
