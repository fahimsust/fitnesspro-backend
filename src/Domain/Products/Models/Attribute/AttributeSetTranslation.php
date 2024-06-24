<?php

namespace Domain\Products\Models\Attribute;

use Domain\Locales\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;


class AttributeSetTranslation extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'attribute_set_translations';

    public function attributeSet():BelongsTo
    {
        return $this->belongsTo(
            AttributeSet::class,
            'set_id'
        );
    }
    public function language():BelongsTo
    {
        return $this->belongsTo(
            Language::class
        );
    }
}
