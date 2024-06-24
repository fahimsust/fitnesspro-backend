<?php

namespace App\Api\Accounts\Rules;

use Closure;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckValidDiscountCode implements ValidationRule
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
        if (!DiscountCondition::ValidDiscount($value)->first()) {
            $fail(__('Invalid Discount Code'));
        }
    }
}
