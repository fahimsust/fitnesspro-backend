<?php

namespace Domain\Products\Models\Product;

use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Kirschbaum\PowerJoins\PowerJoins;
use Support\Traits\HasModelUtilities;

/**
 * Class ProductsChildrenOption
 *
 * @property int $product_id
 * @property int $option_id
 *
 * @package Domain\Products\Models\Product
 */
class ProductVariantOption extends Model
{
    use HasFactory,
        HasModelUtilities,
        PowerJoins;
    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'products_children_options';

    protected $casts = [
        'product_id' => 'int',
        'option_id' => 'int',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class
        );
    }

    public function optionValue(): BelongsTo
    {
        return $this->belongsTo(
            ProductOptionValue::class,
            'option_id'
        );
    }

    public function option(): HasOneThrough
    {
        return $this->hasOneThrough(
            ProductOption::class,
            ProductOptionValue::class,
            'option_id',
            'id',
            'id2',
            'id3'
        );
    }
}
