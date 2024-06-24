<?php

namespace Domain\Products\Models\FulfillmentRules;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductsRulesFulfillmentCondition
 *
 * @property int $id
 * @property int $rule_id
 * @property string $type
 * @property bool $status
 * @property string $any_all
 * @property int $target_distributor
 * @property int $score
 *
 * @property FulfillmentRule $products_rules_fulfillment
 * @property Collection|array<FulfillmentConditionItem> $products_rules_fulfillment_conditions_items
 *
 * @package Domain\Products\Models\Product
 */
class FulfillmentCondition extends Model
{
    public $timestamps = false;
    protected $table = 'products_rules_fulfillment_conditions';

    protected $casts = [
        'rule_id' => 'int',
        'status' => 'bool',
        'target_distributor' => 'int',
        'score' => 'int',
    ];

    protected $fillable = [
        'rule_id',
        'type',
        'status',
        'any_all',
        'target_distributor',
        'score',
    ];

    public function rule()
    {
        return $this->belongsTo(
            FulfillmentRule::class,
            'rule_id'
        );
    }

    public function items()
    {
        return $this->hasMany(
            FulfillmentConditionItem::class,
            'condition_id'
        );
    }
}
