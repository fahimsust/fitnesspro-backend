<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Request;

class AtLeastOneTrue implements ValidationRule
{
    protected $otherField;
    protected $errorMsg;

    /**
     * Create a new rule instance.
     *
     * @param  string  $otherField
     */
    public function __construct(string $otherField, string $errorMsg = "At least one of the fields must be true.")
    {
        $this->otherField = $otherField;
        $this->errorMsg = $errorMsg;
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value && !Request::input($this->otherField)) {
            $fail($this->errorMsg);
        }
    }
}
