<?php

namespace Bedard\Backend\Classes;

use Illuminate\Support\Collection;

class ArrayUtil
{
    /**
     * Deep merge array of records by key
     *
     * @param Collection|array $arr1
     * @param Collection|array $arr2
     * @param string $key
     * 
     * @return array
     */
    public static function mergeBy(Collection|array $arr1, Collection|array $arr2, string $key): array
    {
        if (is_a($arr1, Collection::class)) {
            $arr1 = $arr1->toArray();
        }

        if (is_a($arr2, Collection::class)) {
            $arr2 = $arr2->toArray();
        }

        $result = $arr1;

        $c1 = collect($arr1);

        foreach ($arr2 as $item) {
            $existing = $c1->first(fn ($a) => $a[$key] === $item[$key]);
            
            if ($existing) {
                $index = array_search($existing, $result);
                
                $result[$index] = array_merge($existing, $item);
            } else {
                $result[] = $item;
            }
        }

        return $result;
    }
}