<?php

namespace Bedard\Backend\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DistinctString implements ValidationRule
{
    /**
     * Flags
     *
     * @var array
     */
    protected array $flags;

    /**
     * Values
     *
     * @var array
     */
    protected $values = [];

    /**
     * Construct
     *
     * @param  array  $flags
     *
     * @return self
     */
    public function __construct(...$flags)
    {
        $this->flags = $flags;
    }

    /**
     * Validate
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     *
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // allow duplicate null values
        $nullable = in_array('nullable', $this->flags);

        if ($value === null) {
            return;
        }

        // don't consider string casting when comparing values
        if (in_array('insensitive', $this->flags)) {
            $value = strtolower($value);
        }

        // search for duplicate values
        if (!in_array($value, $this->values)) {
            array_push($this->values, $value);

            return;
        }

        // fail if a duplicate value was found
        $message = $nullable
            ? 'backend::validation.distinct_string_nullable'
            : 'backend::validation.distinct_string';

        $fail($message);
    }
}
