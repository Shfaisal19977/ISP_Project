<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class ThirtyDays implements Rule
{
    public function passes($attribute, $value)
    {
        return Carbon::parse($value)->diffInDays(request()->start_date) === 30;
    }
    public function message()
    {
        return 'The end date must be exactly 30 days after the start date.';
    }
}
