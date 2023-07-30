<?php

namespace Bedard\Backend\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Arr;

class ColumnSpan implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $test = fn ($val) => is_int($val) && $val >= 1 && $val <= 12;

        if (is_array($value) && Arr::isAssoc($value)) {
            foreach ($value as $name => $span) {
                if (!in_array($name, ['xs', 'sm', 'md', 'lg', 'xl', '2xl'])) {
                    $fail("{$attribute}.{$name} is not a valid breakpoint name");
                }

                if (!$test($span)) {
                    $fail("{$attribute}.{$name} must be an integer between 1 and 12");
                }
            }
        } elseif (!$test($value)) {
            $fail("{$attribute} must be an array of breakpoints, or an integer between 1 and 12");
        }
    }
}
