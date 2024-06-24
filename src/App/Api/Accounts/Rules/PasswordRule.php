<?php

namespace App\Api\Accounts\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PasswordRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     *
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pattern = '/[a-z]/';
        if (preg_match($pattern, $value) === 0) {
            $fail('Password must contain at least one lowercase letter');
        }

        $pattern = '/[A-Z]/';
        if (preg_match($pattern, $value) === 0) {
            $fail('Password must contain at least one uppercase letter');
        }

        $pattern = '/[0-9]/';
        if (preg_match($pattern, $value) === 0) {
            $fail('Password must contain at least one digit');
        }

        $pattern = '/[@$!%*#?&]/';
        if (preg_match($pattern, $value) === 0) {
            $fail('Password must contain a special character');
        }
    }
}
