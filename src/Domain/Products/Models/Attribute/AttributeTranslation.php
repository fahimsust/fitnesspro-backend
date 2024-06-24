<?php

namespace Domain\Products\Models\Attribute;

use Domain\Locales\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;


class AttributeTranslation extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'attribute_translations';

    public function attribute():BelongsTo
    {
        return $this->belongsTo(
            Attribute::class
        );
    }
    public function language():BelongsTo
    {
        return $this->belongsTo(
            Language::class
        );
    }
}
