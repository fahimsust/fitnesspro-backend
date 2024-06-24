<?php

namespace App\Api\Accounts\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Support\Helpers\CustomValidation;

class BlackListIP implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     *
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (in_array(CustomValidation::getUserIpAddr(), config('accounts.blacklist_ip'))) {
            $fail('Sorry, our servers are not available.  Please contact us if you have continued issues.');
        }
    }
}
