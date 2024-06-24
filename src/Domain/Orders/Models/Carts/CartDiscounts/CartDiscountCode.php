<?php

namespace Domain\Orders\Models\Carts\CartDiscounts;

use Domain\Discounts\Models\Discount;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Discounts\Models\Rule\DiscountRule;
use Domain\Orders\Actions\Cart\LoadCartById;
use Domain\Orders\Models\Carts\Cart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Staudenmeir\EloquentHasManyDeep\HasOneDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Support\Traits\BelongsTo\BelongsToCart;
use Support\Traits\HasModelUtilities;

class CartDiscountCode extends Model
{
    use HasFactory,
        HasModelUtilities,
        HasRelationships,
        BelongsToCart;

    protected $table = 'cart_discount_codes';

    public function cart(): HasOneThrough
    {
        return $this->hasOneThrough(
            Cart::class,
            CartDiscount::class,
            'id',
            'id',
            'cart_discount_id',
            'cart_id'
        );
    }

    public function cartDiscount(): BelongsTo
    {
        return $this->belongsTo(CartDiscount::class);
    }

    public function condition(): BelongsTo
    {
        return $this->belongsTo(DiscountCondition::class);
    }

    public function discount(): HasOneDeep
    {
        return $this->hasOneDeep(
            Discount::class,
            [
                DiscountCondition::class,
                DiscountRule::class,
            ],
            [
                'id',
                'id',
                'id',
            ],
            [
                'condition_id',
                'rule_id',
                'discount_id',
            ]
        );
    }
}
