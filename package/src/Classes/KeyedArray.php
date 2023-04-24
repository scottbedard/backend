<?php

namespace Bedard\Backend\Classes;

use Illuminate\Support\Arr;

class KeyedArray
{
    /**
     * Create keyed array
     *
     * @param array $source
     * @param string $key
     *
     * @return array
     */
    public static function of(array $source, string $key): array
    {
        if (Arr::isAssoc($source)) {
            $output = [];

            foreach ($source as $k => $value) {
                $output[] = array_merge([$key => $k], $value ?? []);
            }

            return $output;
        }

        foreach ($source as $key => $value) {
            if ($value === null) {
                $source[$key] = [];
            }
        }

        return $source;
    }
}
