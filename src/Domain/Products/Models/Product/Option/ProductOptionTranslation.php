<?php

namespace Domain\Products\Models\Product\Option;

use Domain\Locales\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;


class ProductOptionTranslation extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'product_option_translations';

    public function productOption():BelongsTo
    {
        return $this->belongsTo(
            ProductOption::class
        );
    }
    public function language():BelongsTo
    {
        return $this->belongsTo(
            Language::class
        );
    }
}
