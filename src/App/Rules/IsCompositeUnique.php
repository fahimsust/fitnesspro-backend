<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Facades\DB;

class IsCompositeUnique implements InvokableRule
{
    private string $tableName;
    private array $compositeColsKeyValue = [];
    private $rowId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $tableName, array $compositeColsKeyValue, $rowId = null)
    {
        $this->tableName = $tableName;
        $this->compositeColsKeyValue = $compositeColsKeyValue;
        $this->rowId = $rowId;
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
        $passes = true;

        if ($this->rowId) {
            $record = DB::table($this->tableName)->where($this->compositeColsKeyValue)->first();
            $passes = !$record || ($record && $record->id === $this->rowId);
        } else {
            $passes = !DB::table($this->tableName)->where($this->compositeColsKeyValue)->exists();
        }

        if (!$passes) {
            $fail($this->duplicatesErrorMessage());
        }
    }

    private function duplicatesErrorMessage()
    {
        $colNames = '';
        foreach ($this->compositeColsKeyValue as $col => $value) {
            $colNames .= $col . ', ';
        }
        $colNames = rtrim($colNames, ', ');

        return _('The combination of ') . $colNames . _(' must be unique.');
    }
}
