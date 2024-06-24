<?php

namespace Domain\Discounts\Models\Rule\Condition;

use Domain\Products\Models\Attribute\AttributeOption;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class DiscountRuleConditionAttribute
 *
 * @property int $condition_id
 * @property int $attributevalue_id
 * @property int $required_qty
 *
 * @property AttributeOption $attributes_option
 * @property DiscountCondition $discount_rule_condition
 *
 * @package Domain\Orders\Models\Discount
 */
class ConditionAttribute extends Model
{
    use HasFactory,HasModelUtilities;
    public $timestamps = false;
    protected $table = 'discount_rule_condition_attributes';

    protected $casts = [
        'condition_id' => 'int',
        'attributevalue_id' => 'int',
        'required_qty' => 'int',
    ];

    protected $fillable = [
        'required_qty',
    ];

    public function attributeOption()
    {
        return $this->belongsTo(AttributeOption::class, 'attributevalue_id');
    }

    public function discountCondition()
    {
        return $this->belongsTo(DiscountCondition::class, 'condition_id');
    }
}
