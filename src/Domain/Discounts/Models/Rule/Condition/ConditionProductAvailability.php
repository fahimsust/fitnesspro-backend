<?php

namespace Domain\Discounts\Models\Rule\Condition;

use Domain\Products\Models\Product\ProductAvailability;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class DiscountRuleConditionProductavailability
 *
 * @property int $condition_id
 * @property int $availability_id
 * @property int $required_qty
 *
 * @property ProductAvailability $products_availability
 * @property DiscountCondition $discount_rule_condition
 *
 * @package Domain\Orders\Models\Discount
 */
class ConditionProductAvailability extends Model
{
    use HasFactory,HasModelUtilities;
    public $timestamps = false;
    protected $table = 'discount_rule_condition_productavailabilities';

    protected $casts = [
        'condition_id' => 'int',
        'availability_id' => 'int',
        'required_qty' => 'int',
    ];

    protected $fillable = [
        'required_qty',
    ];

    public function productAvailability()
    {
        return $this->belongsTo(ProductAvailability::class, 'availability_id');
    }

    public function discountCondition()
    {
        return $this->belongsTo(DiscountCondition::class, 'condition_id');
    }
}
