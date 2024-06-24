<?php

namespace Domain\Products\Models\FulfillmentRules;

use Domain\Distributors\Models\Distributor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class ProductsRulesFulfillment
 *
 * @property int $id
 * @property string $name
 * @property bool $status
 * @property string $any_all
 *
 * @property Collection|array<FulfillmentCondition> $products_rules_fulfillment_conditions
 * @property Collection|array<Distributor> $distributors
 * @property Collection|array<FulfillmentRuleSubRule> $products_rules_fulfillment_rules
 *
 * @package Domain\Products\Models\Product
 */
class FulfillmentRule extends Model
{
    use HasFactory,
        HasModelUtilities;
    protected $table = 'products_rules_fulfillment';

    protected $casts = [
        'status' => 'bool',
    ];

    public function conditions()
    {
        return $this->hasMany(
            FulfillmentCondition::class,
            'rule_id'
        );
    }

    public function usedByDistributors()
    {
        //todo
        return $this->hasManyThrough(
            Distributor::class,
            FulfillmentRuleDistributor::class,
            'rule_id'
        )
            ->withPivot('id', 'rank');
    }

    public function subRules()
    {
        return $this->hasMany(
            FulfillmentRuleSubRule::class,
            'parent_rule_id'
        );
    }
}
