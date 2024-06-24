<?php

namespace Domain\Products\Models\FulfillmentRules;

use Domain\Distributors\Models\Distributor;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductsRulesFulfillmentDistributor
 *
 * @property int $id
 * @property int $rule_id
 * @property int $distributor_id
 * @property int $rank
 *
 * @property Distributor $distributor
 * @property FulfillmentRule $products_rules_fulfillment
 *
 * @package Domain\Products\Models\Product
 */
class FulfillmentRuleDistributor extends Model
{
    public $timestamps = false;
    protected $table = 'products_rules_fulfillment_distributors';

    protected $casts = [
        'rule_id' => 'int',
        'distributor_id' => 'int',
        'rank' => 'int',
    ];

    protected $fillable = [
        'rule_id',
        'distributor_id',
        'rank',
    ];

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    public function products_rules_fulfillment()
    {
        return $this->belongsTo(FulfillmentRule::class, 'rule_id');
    }
}
