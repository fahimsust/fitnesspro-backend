<?php

namespace Domain\Products\Models\DatesAutoOrderRules;

use Domain\Products\Models\OrderingRules\OrderingRule;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class ModsDatesAutoOrderrulesAction
 *
 * @property int $id
 * @property int $dao_id
 * @property int $criteria_startdatewithindays
 * @property int|null $criteria_orderingruleid
 * @property int|null $criteria_siteid
 * @property int $changeto_orderingruleid
 * @property bool $status
 *
 * @property OrderingRule|null $products_rules_ordering
 * @property Site|null $site
 * @property DatesAutoOrderRule $mods_dates_auto_orderrule
 *
 * @package Domain\Products\Models\Mods
 */
class DatesAutoOrderRuleAction extends Model
{
    use HasFactory,
        HasModelUtilities;
    protected $table = 'dates_auto_orderrules_action';

    protected $casts = [
        'dao_id' => 'int',
        'criteria_startdatewithindays' => 'int',
        'criteria_orderingruleid' => 'int',
        'criteria_siteid' => 'int',
        'changeto_orderingruleid' => 'int',
        'status' => 'bool',
    ];

    public function orderingRuleCriteria()
    {
        return $this->belongsTo(OrderingRule::class, 'criteria_orderingruleid');
    }

    public function orderingRuleUpdate()
    {
        return $this->belongsTo(
            OrderingRule::class,
            'changeto_orderingruleid'
        );
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'criteria_siteid');
    }

    public function autoOrderRule()
    {
        return $this->belongsTo(DatesAutoOrderRule::class, 'dao_id');
    }
}
