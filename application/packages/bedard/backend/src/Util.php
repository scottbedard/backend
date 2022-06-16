<?php

namespace Bedard\Backend;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
class Util
{
    /**
     * Attempt a function that might throw an error.
     *
     * @param function $callback
     *
     * @return mixed
     */
    public static function attempt($callback)
    {
        try {
            return $callback();
        } catch (Exception $e) {}

        return null;
    }

    /**
     * Get a model's ID
     *
     * @param \Illuminate\Database\Eloquent\Model|int|string $modelOrId
     *
     * @return int
     */
    public static function getId(Model|int|string $value)
    {
        if ($value instanceof Model) {
            return $value->id;
        }

        if (is_int($value)) {
            return $value;
        }
        
        return intval($value);
    }

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