<?php

namespace Domain\Discounts\Models\Rule\Condition;

use Domain\Discounts\Enums\OnSaleStatuses;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;

/**
 * Class DiscountRuleConditionOnsalestatus
 *
 * @property int $condition_id
 * @property OnSaleStatuses $onsalestatus_id
 * @property int $required_qty
 *
 * @property DiscountCondition $discount_rule_condition
 *
 * @package Domain\Orders\Models\Discount
 */
class ConditionOnSaleStatus extends Model
{
    use HasFactory,
        HasModelUtilities;

    public $timestamps = false;
    protected $table = 'discount_rule_condition_onsalestatuses';

    protected $casts = [
        'condition_id' => 'int',
        'onsalestatus_id' => OnSaleStatuses::class,
        'required_qty' => 'int',
    ];

    protected $fillable = [
        'required_qty',
    ];

    public function discountCondition(): BelongsTo
    {
        return $this->belongsTo(
            DiscountCondition::class,
            'condition_id'
        );
    }
}
