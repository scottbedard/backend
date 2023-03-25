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
    protected string $originalPath;

    /**
     * Create url path
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->originalPath = $path;
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

        $str = Str::of($path)->trim()->ltrim('/');

        if (!$str->length()) {
            return false;
        }

        return preg_match('/^(\/?\w+)*(\/?{\w+})*(\/?{\w+\?})?$/i', $str) === 1;
    }
}