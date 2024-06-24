<?php

namespace Domain\CustomForms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class FormSectionField extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'custom_forms_sections_fields';

    protected $casts = [
        'section_id' => 'int',
        'field_id' => 'int',
        'required' => 'bool',
        'rank' => 'int',
        'new_row' => 'bool',
    ];

    public function field()
    {
        return $this->belongsTo(CustomField::class, 'field_id');
    }

    public function section()
    {
        return $this->belongsTo(FormSection::class, 'section_id');
    }
}
