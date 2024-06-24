<?php

namespace Domain\Discounts\Models\Level;

use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Support\Traits\HasModelUtilities;

/**
 * Class DiscountsLevelsProduct
 *
 * @property int $id
 * @property int $discount_level_id
 * @property int $product_id
 *
 * @property DiscountLevel $discounts_level
 * @property Product $product
 *
 * @package Domain\Orders\Models\Discount
 */
class DiscountLevelProduct extends Model
{
    use HasFactory,
        HasModelUtilities;

    public $timestamps = false;
    protected $table = 'discounts_levels_products';

    protected $casts = [
        'discount_level_id' => 'int',
        'product_id' => 'int',
    ];

    protected $fillable = [
        'discount_level_id',
        'product_id',
    ];

    public function level()
    {
        return $this->belongsTo(DiscountLevel::class, 'discount_level_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
