<?php

namespace Domain\Products\Models\Product\AccessoryField;

use Domain\Products\Enums\PriceAdjustTargets;
use Domain\Products\Enums\PriceAdjustTypes;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
use Support\Traits\HasModelUtilities;

/**
 * Class AccessoriesFieldsProduct
 *
 * @property int $accessories_fields_id
 * @property int $product_id
 * @property string $label
 * @property int $rank
 * @property bool $price_adjust_type
 * @property bool $price_adjust_calc
 * @property float $price_adjust_amount
 *
 * @property AccessoryField $accessories_field
 * @property Product $product
 *
 * @package Domain\Products\Models
 */
class AccessoryFieldProduct extends Model
{
    use HasFactory,
        HasModelUtilities,
        PowerJoins;
    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'accessories_fields_products';

    protected $casts = [
        'accessories_fields_id' => 'int',
        'product_id' => 'int',
        'rank' => 'int',
        'price_adjust_type' => PriceAdjustTargets::class,
        'price_adjust_calc' => PriceAdjustTypes::class,
        'price_adjust_amount' => 'float',
    ];

    protected $fillable = [
        'label',
        'rank',
        'price_adjust_type',
        'price_adjust_calc',
        'price_adjust_amount',
    ];

    public function field()
    {
        return $this->belongsTo(AccessoryField::class, 'accessories_fields_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
