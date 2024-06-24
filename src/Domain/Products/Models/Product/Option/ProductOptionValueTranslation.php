<?php

namespace Domain\Products\Models\Product\Option;

use Domain\Locales\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;


class ProductOptionValueTranslation extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'product_option_value_translations';

    public function productOptionValue():BelongsTo
    {
        return $this->belongsTo(
            ProductOptionValue::class
        );
    }
    public function language():BelongsTo
    {
        return $this->belongsTo(
            Language::class
        );
    }

}
