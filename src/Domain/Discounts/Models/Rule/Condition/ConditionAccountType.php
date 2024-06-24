<?php

namespace Domain\Discounts\Models\Rule\Condition;

use Domain\Accounts\Models\AccountType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class DiscountRuleConditionAccounttype
 *
 * @property int $condition_id
 * @property int $accounttype_id
 *
 * @property AccountType $accounts_type
 * @property DiscountCondition $discount_rule_condition
 *
 * @package Domain\Orders\Models\Discount
 */
class ConditionAccountType extends Model
{
    use HasFactory, HasModelUtilities;
    protected $table = 'discount_rule_condition_accounttypes';

    protected $casts = [
        'condition_id' => 'int',
        'accounttype_id' => 'int',
    ];

    public function accountType()
    {
        return $this->belongsTo(AccountType::class, 'accounttype_id');
    }

    public function discountCondition()
    {
        return $this->belongsTo(DiscountCondition::class, 'condition_id');
    }
}
