<?php

namespace Domain\CustomForms\Models;

use Domain\Accounts\Models\AccountField;
use Domain\CustomForms\QueryBuilders\CustomFieldQuery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class CustomField extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;

    protected $table = 'custom_fields';

    protected $casts = [
        'type' => 'int',
        'required' => 'bool',
        'rank' => 'int',
        'status' => 'bool',
    ];

    protected $fillable = [
        'display',
        'name',
        'type',
        'required',
        'rank',
        'cssclass',
        'options',
        'specs',
        'status',
    ];

    public function translations()
    {
        return $this->hasMany(
            CustomFieldTranslation::class,'field_id'
        );
    }

    public function accountFields()
    {
        return $this->hasMany(AccountField::class, 'field_id');
    }
    public function options()
    {
        return $this->hasMany(CustomFieldOption::class, 'field_id');
    }
    public function formSections()
    {
        return $this->hasMany(FormSectionField::class, 'field_id');
    }
    public function newEloquentBuilder($query)
    {
        return new CustomFieldQuery($query);
    }
}
