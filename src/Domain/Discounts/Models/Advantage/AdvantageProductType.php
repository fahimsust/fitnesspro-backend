<?php

namespace Domain\Discounts\Models\Advantage;

use Domain\Products\Models\Product\ProductType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;

/**
 * Class DiscountAdvantageProducttype
 *
 * @property int $advantage_id
 * @property int $producttype_id
 * @property int $applyto_qty
 *
 * @property DiscountAdvantage $discount_advantage
 * @property ProductType $products_type
 *
 * @package Domain\Orders\Models\Discount
 */
class AdvantageProductType extends Model
{
    use HasFactory,
        HasModelUtilities;

    public $timestamps = false;

    protected $table = 'discount_advantage_producttypes';

    protected $casts = [
        'advantage_id' => 'int',
        'producttype_id' => 'int',
        'applyto_qty' => 'int',
    ];

    protected $fillable = [
        'advantage_id',
        'producttype_id',
        'applyto_qty',
    ];

    public function discountAdvantage(): BelongsTo
    {
        return $this->belongsTo(
            DiscountAdvantage::class,
            'advantage_id'
        );
    }

    public function productType(): BelongsTo
    {
        return $this->belongsTo(
            ProductType::class,
            'producttype_id'
        );
    }
}
