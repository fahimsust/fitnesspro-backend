<?php

namespace Domain\CustomForms\Models;

use Domain\Locales\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;


class CustomFormTranslation extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'custom_form_translations';

    public function customForm():BelongsTo
    {
        return $this->belongsTo(
            CustomForm::class
        );
    }
    public function language():BelongsTo
    {
        return $this->belongsTo(
            Language::class
        );
    }
}
