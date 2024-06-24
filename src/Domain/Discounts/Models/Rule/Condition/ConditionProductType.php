<?php

namespace Domain\Discounts\Models\Rule\Condition;

use Domain\Products\Models\Product\ProductType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class DiscountRuleConditionProducttype
 *
 * @property int $condition_id
 * @property int $producttype_id
 * @property int $required_qty
 *
 * @property DiscountCondition $discount_rule_condition
 * @property ProductType $products_type
 *
 * @package Domain\Orders\Models\Discount
 */
class ConditionProductType extends Model
{
    use HasFactory,HasModelUtilities;
    public $timestamps = false;
    protected $table = 'discount_rule_condition_producttypes';

    protected $casts = [
        'condition_id' => 'int',
        'producttype_id' => 'int',
        'required_qty' => 'int',
    ];

    protected $fillable = [
        'required_qty',
    ];

    public function discountCondition()
    {
        return $this->belongsTo(DiscountCondition::class, 'condition_id');
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'producttype_id');
    }
}
