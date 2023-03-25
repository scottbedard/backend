<?php

namespace Bedard\Backend\Classes;

use Exception;
use Illuminate\Support\Str;

class UrlPath
{
    /**
     * The original path
     *
     * @var string
     */
    public string $original;

    /**
     * Segments
     *
     * @var array
     */
    public array $segments;

    /**
     * Create url path
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        if (!self::validate($path)) {
            throw new Exception('Invalid url path: ' . $path);
        }

        $this->original = $path;

        $this->segments = Str::of($path)
            ->trim()
            ->ltrim('/')
            ->explode('/')
            ->map(function ($segment) {
                $name = Str::of($segment)->ltrim('{')->rtrim('}')->rtrim('?')->toString();

                $optional = Str::contains($segment, '?');
                
                $param = Str::startsWith($segment, '{') && Str::endsWith($segment, '}');

                return [
                    'name' => $name,
                    'optional' => $optional,
                    'param' => $param,
                ];
            })
            ->toArray();
    }

    /**
     * Validate a url path
     *
     * @param string $path
     *
     * @return bool
     */
    public static function validate(string $path): bool
    {
        if ($path === '/') {
            return true;
        }

        $str = Str::of($path)
            ->trim()
            ->ltrim('/');

        if (!$str->length()) {
            return false;
        }

        return preg_match('/^(\/?\w+)*(\/?{\w+})*(\/?{\w+\?})?$/i', $str) === 1;
    }
}