<?php

namespace Domain\Discounts\Models\Rule\Condition;

use Domain\Locales\Models\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class DiscountRuleConditionCountry
 *
 * @property int $condition_id
 * @property int $country_id
 *
 * @property DiscountCondition $discount_rule_condition
 * @property Country $country
 *
 * @package Domain\Orders\Models\Discount
 */
class ConditionCountry extends Model
{
    use HasFactory,HasModelUtilities;
    public $timestamps = false;
    protected $table = 'discount_rule_condition_countries';

    protected $casts = [
        'condition_id' => 'int',
        'country_id' => 'int',
    ];

    public function discountCondition()
    {
        return $this->belongsTo(DiscountCondition::class, 'condition_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
