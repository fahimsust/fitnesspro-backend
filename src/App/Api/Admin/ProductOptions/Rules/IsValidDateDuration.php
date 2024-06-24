<?php

namespace App\Api\Admin\ProductOptions\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class IsValidDateDuration implements ValidationRule, DataAwareRule
{
    private Carbon $start_date;
    private Carbon $end_date;
    private int $skip;
    public function setData(array $data): static
    {
        $this->start_date = new Carbon($data['start_date']);
        $this->end_date = new Carbon($data['end_date']);
        $this->skip = (int)$data['days_skip_between'];
        return $this;
    }
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if ($this->start_date->diffInDays($this->end_date) < $value) {
            $fail(__("Can't create option value: Date duration is greater then date difference between start date and end date"));
        } else {
            if (($this->skip + $value) < 1)
                $fail(__('Duration + Skip has to be 1 or more'));
        }
    }
}
