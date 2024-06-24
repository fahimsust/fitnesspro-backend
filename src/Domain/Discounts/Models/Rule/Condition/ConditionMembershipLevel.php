<?php

namespace Domain\Discounts\Models\Rule\Condition;

use Domain\Accounts\Models\Membership\MembershipLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class DiscountRuleConditionMembershiplevel
 *
 * @property int $condition_id
 * @property int $membershiplevel_id
 *
 * @property DiscountCondition $discount_rule_condition
 * @property MembershipLevel $accounts_membership_level
 *
 * @package Domain\Orders\Models\Discount
 */
class ConditionMembershipLevel extends Model
{
    use HasFactory, HasModelUtilities;
    protected $table = 'discount_rule_condition_membershiplevels';

    protected $casts = [
        'condition_id' => 'int',
        'membershiplevel_id' => 'int',
    ];

    public function discountCondition()
    {
        return $this->belongsTo(DiscountCondition::class, 'condition_id');
    }

    public function membershipLevel()
    {
        return $this->belongsTo(MembershipLevel::class, 'membershiplevel_id');
    }
}
