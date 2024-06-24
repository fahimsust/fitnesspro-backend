<?php

namespace App\Api\Accounts\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Domain\Accounts\Models\Membership\MembershipLevel;

class CheckValidLevelMethod implements ValidationRule
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
        if (!(MembershipLevel::where(['id' => $value, 'status' => true])->first())) {
            $fail(__('Invalid membership level'));
        }
    }
}
