<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneNumberValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }
    public function passes($attribute, $value)
    {
        // Implement your phone number validation logic here
        // You can use regular expressions or database checks:

        // Basic validation for digits and hyphens
        if (!preg_match('/^[\d+-]+$/', $value)) {
            return false;
        }

        // Optional: Additional validation (e.g., length, country code)
        // $minLength = 10; // Adjust based on your requirements
        // if (strlen($value) < $minLength) {
        //    return false;
        // }

        // Optional: Database check for existing phone numbers (if applicable)
        // $user = DB::table('users')->where('phone_number', $value)->exists();
        // if ($user) {
        //    return false;
        // }

        return true;
    }
    public function message()
    {
        return 'The phone number format is invalid.';
    }
}
