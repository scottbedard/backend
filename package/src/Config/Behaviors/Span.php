<?php

namespace Bedard\Backend\Config\Behaviors;

use Bedard\Backend\Classes\Breakpoint;

class Span extends Behavior
{
    /**
     * Default span
     *
     * @return int
     */
    public function getDefaultSpan(): int
    {
        return 12;
    }

    /**
     * Set span
     *
     * @param array|int $span
     *
     * @return array
     */
    public function setSpanAttribute(array|int $span): array
    {
        return Breakpoint::create($span);
    }
}
