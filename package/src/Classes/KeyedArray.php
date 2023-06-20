<?php

namespace Bedard\Backend\Classes;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class KeyedArray
{
    /**
     * Create keyed array from associative array
     *
     * @param  \Illuminate\Support\Collection|array  $source
     * @param  string  $key
     *
     * @return array
     */
    public static function from(Collection|array $source, string $key): array
    {
        if ($source instanceof Collection) {
            $source = $source->toArray();
        }

        if (Arr::isAssoc($source)) {
            $output = [];

            foreach ($source as $k => $value) {
                $output[] = array_merge([$key => $k], $value ?? []);
            }

            return collect($output)
                ->sortBy('order')
                ->values()
                ->toArray();
        }

        foreach ($source as $key => $value) {
            if ($value === null) {
                $source[$key] = [];
            }
        }

        return $source;
    }
}
