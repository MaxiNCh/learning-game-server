<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AtLeastTwoAnswers implements Rule
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
        $answersAmount = 0;

        foreach ($value as $arrayElement) {
            if (!empty($arrayElement['text'])) {
                $answersAmount += 1;
            }
        }

        if ($answersAmount > 1) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Each question must have at least two answers';
    }
}
