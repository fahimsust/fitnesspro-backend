<?php

namespace Domain\Products\Models\Product;

use Domain\Locales\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;


class ProductTranslation extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'product_translations';

    public function product():BelongsTo
    {
        return $this->belongsTo(
            Product::class
        );
    }
    public function language():BelongsTo
    {
        return $this->belongsTo(
            Language::class
        );
    }
}
