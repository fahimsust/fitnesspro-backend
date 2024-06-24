<?php

namespace Domain\CustomForms\Models;

use Domain\Locales\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;


class CustomFieldTranslation extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'custom_field_translation';

    public function customField():BelongsTo
    {
        return $this->belongsTo(
            CustomField::class,
            'field_id'
        );
    }
    public function language():BelongsTo
    {
        return $this->belongsTo(
            Language::class
        );
    }
}
