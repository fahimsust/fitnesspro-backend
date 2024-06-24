<?php

namespace Domain\Products\Models\Attribute;

use Domain\Locales\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;


class AttributeOptionTranslation extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'attribute_option_translations';

    public function option():BelongsTo
    {
        return $this->belongsTo(
            AttributeOption::class,
            'option_id'
        );
    }
    public function language():BelongsTo
    {
        return $this->belongsTo(
            Language::class
        );
    }
}
