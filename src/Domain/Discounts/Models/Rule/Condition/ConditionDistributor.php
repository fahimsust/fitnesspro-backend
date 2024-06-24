<?php

namespace Domain\Discounts\Models\Rule\Condition;

use Domain\Distributors\Models\Distributor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class DiscountRuleConditionDistributor
 *
 * @property int $condition_id
 * @property int $distributor_id
 *
 * @property DiscountCondition $discount_rule_condition
 * @property Distributor $distributor
 *
 * @package Domain\Orders\Models\Discount
 */
class ConditionDistributor extends Model
{
    use HasFactory,HasModelUtilities;
    public $timestamps = false;
    protected $table = 'discount_rule_condition_distributors';

    protected $casts = [
        'condition_id' => 'int',
        'distributor_id' => 'int',
    ];

    public function discountCondition()
    {
        return $this->belongsTo(DiscountCondition::class, 'condition_id');
    }

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }
}
