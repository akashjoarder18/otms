<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ClassDayVerifyRule implements Rule
{
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        $result = true;
        $days = ['Saturday', 'Sunday', 'Monday', ' Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        foreach (explode(',', $value) as $key => $day) {
            if (!in_array($day, $days)) {
                $result = false;
                break;
            }
        }
        return $result;
    }

    public function message()
    {
        return 'Class days format does not match.';
    }
}
