<?php

namespace App\Api\Accounts\Rules;

use function config;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BlackListEmail implements ValidationRule
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
        $tlds = config('accounts.blacklist_email_tld');
        if ($tlds) {
            $email = explode('@', $value);

            $tld_array = explode('.', $email[1]);

            $tld = end($tld_array);

            if (in_array(strtolower($tld), $tlds)) {
                $fail('Sorry, our servers are not available.  Please contact us if you have continued issues.');
            }
        }
    }
}
