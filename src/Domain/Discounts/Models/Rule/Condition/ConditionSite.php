<?php

namespace Domain\Discounts\Models\Rule\Condition;

use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class DiscountRuleConditionSite
 *
 * @property int $condition_id
 * @property int $site_id
 *
 * @property DiscountCondition $discount_rule_condition
 * @property Site $site
 *
 * @package Domain\Orders\Models\Discount
 */
class ConditionSite extends Model
{
    use HasFactory,HasModelUtilities;
    public $timestamps = false;

    protected $table = 'discount_rule_condition_sites';

    protected $casts = [
        'condition_id' => 'int',
        'site_id' => 'int',
    ];

    public function discountCondition()
    {
        return $this->belongsTo(DiscountCondition::class, 'condition_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
