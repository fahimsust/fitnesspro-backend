<?php

namespace Domain\Products\Models\OrderingRules;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class ProductsRulesOrderingRule
 *
 * @property int $id
 * @property int $parent_rule_id
 * @property int $child_rule_id
 *
 * @property OrderingRule $products_rules_ordering
 * @property Collection|array<OrderingCondition> $products_rules_ordering_conditions
 *
 * @package Domain\Products\Models\Product
 */
class OrderingRuleSubRule extends Model
{
    use HasFactory,
        HasModelUtilities;
    protected $table = 'products_rules_ordering_rules';

    protected $casts = [
        'parent_rule_id' => 'int',
        'child_rule_id' => 'int',
    ];

    public function parent()
    {
        return $this->belongsTo(
            OrderingRule::class,
            'parent_rule_id'
        );
    }

    public function child()
    {
        return $this->belongsTo(
            OrderingRule::class,
            'child_rule_id'
        );
    }
// todo if fk is setup this way, this is wrong.  this table
// relates additional rules to another rule
// and does not have conditions of its own
// conditions link to OrderingRule
//  public function conditions()
//  {
//      return $this->hasMany(
//            OrderingRuleCondition::class,
//            'rule_id'
//        );
//  }
}
