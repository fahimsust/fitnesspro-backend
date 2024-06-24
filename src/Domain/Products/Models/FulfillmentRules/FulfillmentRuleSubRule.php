<?php

namespace Domain\Products\Models\FulfillmentRules;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductsRulesFulfillmentRule
 *
 * @property int $id
 * @property int $parent_rule_id
 * @property int $child_rule_id
 *
 * @property FulfillmentRule $products_rules_fulfillment
 *
 * @package Domain\Products\Models\Product
 */
class FulfillmentRuleSubRule extends Model
{
    public $timestamps = false;
    protected $table = 'products_rules_fulfillment_rules';

    protected $casts = [
        'parent_rule_id' => 'int',
        'child_rule_id' => 'int',
    ];

    protected $fillable = [
        'parent_rule_id',
        'child_rule_id',
    ];

    public function products_rules_fulfillment()
    {
        return $this->belongsTo(FulfillmentRule::class, 'parent_rule_id');
    }
}
