<?php

namespace Domain\CustomForms\Models;

use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomFieldOption extends Model
{
    use HasModelUtilities,HasFactory;

    protected $table = 'custom_field_options';

    public function formSectionFields()
    {
        return $this->belongsTo(FormSectionField::class, 'field_id');
    }
}
