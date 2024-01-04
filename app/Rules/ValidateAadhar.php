<?php

namespace App\Rules;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Rule;

class ValidateAadhar implements Rule
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
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $parameters = '/^([0-9]){12}?$/';
        return preg_match($parameters, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You have entered is incorrect Aadhar Card No.';
    }
}
