<?php

namespace Domain\Discounts\Models\Advantage;

use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class DiscountAdvantageProduct
 *
 * @property int $advantage_id
 * @property int $product_id
 * @property int $applyto_qty
 *
 * @property DiscountAdvantage $discount_advantage
 * @property Product $product
 *
 * @package Domain\Orders\Models\Discount
 */
class AdvantageProduct extends Model
{
    use HasFactory,
        HasModelUtilities;

    public $timestamps = false;

    protected $table = 'discount_advantage_products';

    protected $casts = [
        'advantage_id' => 'int',
        'product_id' => 'int',
        'applyto_qty' => 'int',
    ];

    protected $fillable = [
        'advantage_id',
        'product_id',
        'applyto_qty',
    ];

    public function discountAdvantage()
    {
        return $this->belongsTo(DiscountAdvantage::class, 'advantage_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
