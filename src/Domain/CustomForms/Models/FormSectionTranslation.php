<?php

namespace Domain\CustomForms\Models;

use Domain\Locales\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;


class FormSectionTranslation extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'custom_form_section_translations';

    public function formSection():BelongsTo
    {
        return $this->belongsTo(
            FormSection::class
        );
    }
    public function language():BelongsTo
    {
        return $this->belongsTo(
            Language::class
        );
    }
}
