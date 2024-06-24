<?php

namespace App\Api\Accounts\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Domain\Payments\Models\PaymentMethod;

class IsValidSubscriptionPaymentMethod implements ValidationRule
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
        if (!PaymentMethod::subscriptionOptions(config('site.id'))->find($value)) {
            $fail(__('Invalid Payment Method'));
        }
    }
}
