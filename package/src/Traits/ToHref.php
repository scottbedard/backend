<?php

namespace Bedard\Backend\Traits;

use Bedard\Backend\Classes\Href;

trait ToHref
{
    /**
     * Set href
     *
     * @param ?string $href
     *
     * @return ?string
     */
    public function setHrefAttribute(?string $to): ?string
    {
        return Href::format(
            config: $this->root(),
            to: $to,
        );
    }
}
