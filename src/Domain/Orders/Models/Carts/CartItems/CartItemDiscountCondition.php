<?php

namespace Domain\Orders\Models\Carts\CartItems;

use Domain\Discounts\Models\Discount;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Discounts\Models\Rule\DiscountRule;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Staudenmeir\EloquentHasManyDeep\HasOneDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Support\Traits\HasModelUtilities;

class CartItemDiscountCondition extends Model
{
    use HasFactory, HasModelUtilities,
        HasRelationships;

    public function item(): BelongsTo
    {
        return $this->belongsTo(CartItem::class);
    }

    public function condition(): BelongsTo
    {
        return $this->belongsTo(DiscountCondition::class);
    }

    public function cartDiscount()
    {
        return $this->belongsTo(CartDiscount::class);
    }

    public function discount(): HasOneDeep
    {
        return $this->hasOneDeep(
            Discount::class,
            [DiscountCondition::class, DiscountRule::class],
            ['id', 'id', 'id'],
            ['condition_id', 'rule_id', 'discount_id']
        );
    }
}
