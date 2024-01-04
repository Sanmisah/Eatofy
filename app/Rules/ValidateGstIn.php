<?php

namespace App\Rules;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Rule;

class ValidateGstIn implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool ^[1-9A-Z]{1}Z[0-9A-Z]{1}$
     */
    public function passes($attribute, $value)
    {
        $parameters = '/^([0-9]){2}([A-Z]){5}([0-9]){4}([A-Z]){1}([1-9]){1}([A-Z]){1}([1-9]){1}?$/';
        // $parameters = '/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/';
        return preg_match($parameters, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You have entered incorrect GST No.';
    }
}
