<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Facades\DB;

class ExistsInModels implements InvokableRule
{
    private array $tables;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(array $tables)
    {
        $this->tables = $tables;
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     *
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $passes = false;

        foreach ($this->tables as $table) {
            if (DB::table($table)->find($value)) {
                $passes = true;
                break;
            }
        }

        if (!$passes) {
            $fail(_('The :attribute must be exists in ') . implode(' or ', $this->tables));
        }
    }
}
