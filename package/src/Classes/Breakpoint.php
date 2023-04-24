<?php

namespace Bedard\Backend\Classes;

class Breakpoint
{
    /**
     * Create a breakpoints array.
     *
     * @param array|int $span
     *
     * @return array
     */
    public static function create(array|int $span): array
    {
        if (is_int($span)) {
            return [
                'xs' => 12,
                'sm' => 12,
                'md' => 12,
                'lg' => $span,
                'xl' => $span,
                '2xl' => $span,
            ];
        }

        $xs = data_get($span, 'xs', 12);

        $sm = data_get($span, 'sm', $xs);

        $md = data_get($span, 'md', $sm);

        $lg = data_get($span, 'lg', $md);

        $xl = data_get($span, 'xl', $lg);

        $xxl = data_get($span, '2xl', $xl);

        return [
            'xs' => $xs,
            'sm' => $sm,
            'md' => $md,
            'lg' => $lg,
            'xl' => $xl,
            '2xl' => $xxl,
        ];
    }
}