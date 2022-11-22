<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AtLeastOneIsIncorrect implements Rule
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
        foreach ($value as $arrayElement) {
            if (!empty($arrayElement['text'])) {
                if ($arrayElement['isCorrect'] == false) {
                    return true;
                }
            }
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
        return 'At least one answer must be false';
    }
}
