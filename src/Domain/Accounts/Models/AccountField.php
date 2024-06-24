<?php

namespace Domain\Accounts\Models;

use Domain\CustomForms\Models\CustomField;
use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\FormSection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class AccountField extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'accounts_addtl_fields';

    public function getValueAttribute()
    {
        return htmlspecialchars_decode($this->field_value);
    }

    public function setValueAttribute($value)
    {
        $this->attributes['field_value'] = htmlspecialchars($value);
    }

    public static function FindByAccountAndFieldId(Account $account, $fieldId)
    {
        return self::query()->whereAccountId($account->id)->whereFieldId($fieldId)->firstOrFail();
    }

    public function form()
    {
        return $this->hasOne(CustomForm::class, 'id', 'form_id');
    }

    public function formSection()
    {
        return $this->hasOne(FormSection::class, 'id', 'section_id');
    }

    public function field()
    {
        return $this->hasOne(CustomField::class, 'id', 'field_id');
    }

    public function account()
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }
}
