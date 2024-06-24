<?php

namespace Domain\Discounts\Models\Rule\Condition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class DiscountRuleConditionOutofstockstatus
 *
 * @property int $condition_id
 * @property int $outofstockstatus_id
 * @property int $required_qty
 *
 * @property DiscountCondition $discount_rule_condition
 *
 * @package Domain\Orders\Models\Discount
 */
class ConditionOutOfStockStatus extends Model
{
    use HasFactory,HasModelUtilities;
    public $timestamps = false;
    protected $table = 'discount_rule_condition_outofstockstatuses';

    protected $casts = [
        'condition_id' => 'int',
        'outofstockstatus_id' => 'int',
        'required_qty' => 'int',
    ];

    protected $fillable = [
        'required_qty',
    ];

    //todo build enum for outofstockstatus_id

    public function discountCondition()
    {
        return $this->belongsTo(DiscountCondition::class, 'condition_id');
    }
}
