<?php

namespace Bedard\Backend\Classes;

class Sort
{
    /**
     * The column to sort by.
     *
     * @var string|null
     */
    public ?string $column = null;

    /**
     * The direction to sort by.
     *
     * @var int
     */
    public int $direction = 0;

    /**
     * The original URL.
     *
     * @var string
     */
    public string $url;

    /**
     * Construct
     *
     * @param  string  $url
     * @param  string  $id
     */
    public function __construct(string $url, ?string $column = null)
    {
        $this->url = $url;

        $parts = parse_url($url);

        if (!array_key_exists('query', $parts)) {
            return;
        }

        $query = [];

        parse_str($parts['query'], $query);

        if (!array_key_exists('sort', $query)) {
            return;
        }

        $sort = array_map('trim', explode(',', strtolower($query['sort'])));

        if (count($sort) === 2 && (is_null($column) || $column === $sort[0])) {
            $this->column = $sort[0];

            $this->direction = $sort[1] === 'asc' ? 1 : ($sort[1] === 'desc' ? -1 : 0);
        }
    }

    /**
     * Static constructor
     *
     * @param  mixed  ...$args
     *
     * @return static
     */
    public static function create(...$args): static
    {
        return new static(...$args);
    }
}
