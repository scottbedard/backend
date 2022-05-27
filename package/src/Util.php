<?php

namespace Bedard\Backend;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Util
{
    /**
     * Suggest a string based on closest levenshtein distance to other strings.
     *
     * @param string $needle
     * @param iterable $haystack
     * @param callable $normalizer
     *
     * @return string
     */
    public static function suggest(string $needle, iterable $haystack, callable $normalizer = null): string
    {
        $normalizer = $normalizer ?: fn ($str) => $str;
        $needle = $normalizer($needle);
        $haystack = array_map($normalizer, Collection::wrap($haystack)->toArray());
        
        if (in_array($needle, $haystack)) {
            return $needle;
        }

        $closest = $needle;
        $closestDistance = INF;
        
        foreach ($haystack as $item) {
            $distance = levenshtein($needle, $item);

            if ($distance < $closestDistance) {
                $closest = $item;
                $closestDistance = $distance;
            }
        }

        return $closest;
    }
}