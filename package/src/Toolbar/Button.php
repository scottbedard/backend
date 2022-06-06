<?php

namespace Bedard\Backend\Toolbar;

use Bedard\Backend\Toolbar;

class Button extends Toolbar
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
     * @var string
     */
    public ?string $theme = null;

    /**
     * To
     *
     * @var string|callable
     */
    public $to = '#';
}
