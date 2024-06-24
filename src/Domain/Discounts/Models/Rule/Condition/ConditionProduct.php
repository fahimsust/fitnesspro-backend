<?php

namespace Domain\Discounts\Models\Rule\Condition;

use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class DiscountRuleConditionProduct
 *
 * @property int $condition_id
 * @property int $product_id
 * @property int $required_qty
 *
 * @property DiscountCondition $discount_rule_condition
 * @property Product $product
 *
 * @package Domain\Orders\Models\Discount
 */
class ConditionProduct extends Model
{
    use HasFactory,HasModelUtilities;
    public $timestamps = false;
    protected $table = 'discount_rule_condition_products';

    protected $casts = [
        'condition_id' => 'int',
        'product_id' => 'int',
        'required_qty' => 'int',
    ];

    protected $fillable = [
        'required_qty',
    ];

    public function discount_rule_condition()
    {
        return $this->belongsTo(DiscountCondition::class, 'condition_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
