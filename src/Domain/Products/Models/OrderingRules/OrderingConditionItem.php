<?php

namespace Domain\Products\Models\OrderingRules;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class ProductsRulesOrderingConditionsItem
 *
 * @property int $id
 * @property int $condition_id
 * @property int $item_id
 *
 * @property OrderingCondition $products_rules_ordering_condition
 *
 * @package Domain\Products\Models\Product
 */
class OrderingConditionItem extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'products_rules_ordering_conditions_items';

    protected $casts = [
        'condition_id' => 'int',
        'item_id' => 'int',
    ];

    public function condition()
    {
        return $this->belongsTo(
            OrderingCondition::class,
            'condition_id'
        );
    }
}
