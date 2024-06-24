<?php

namespace Domain\Products\Models\FulfillmentRules;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductsRulesFulfillmentConditionsItem
 *
 * @property int $id
 * @property int $condition_id
 * @property int $item_id
 * @property string $value
 *
 * @property FulfillmentCondition $products_rules_fulfillment_condition
 *
 * @package Domain\Products\Models\Product
 */
class FulfillmentConditionItem extends Model
{
    public $timestamps = false;
    protected $table = 'products_rules_fulfillment_conditions_items';

    protected $casts = [
        'condition_id' => 'int',
        'item_id' => 'int',
    ];

    protected $fillable = [
        'condition_id',
        'item_id',
        'value',
    ];

    public function condition()
    {
        return $this->belongsTo(FulfillmentCondition::class, 'condition_id');
    }
}
