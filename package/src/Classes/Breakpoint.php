<?php

namespace Bedard\Backend\Classes;

class Breakpoint
{
    /**
     * Create a breakpoints array.
     *
     * @param  array|int  $span
     * @param  int  $cols
     *
     * @return array
     */
    public static function create(array|int $span, int $cols = 12): array
    {
        if (is_int($span)) {
            return [
                'xs' => $cols,
                'sm' => $cols,
                'md' => $span,
                'lg' => $span,
                'xl' => $span,
                '2xl' => $span,
            ];
        }

        $xs = data_get($span, 'xs', $cols);

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

    /**
     * Return breakpoints as json
     */
    public static function json(...$args)
    {
        return json_encode(static::create(...$args));
    }
}
