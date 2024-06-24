<?php

namespace Domain\Orders\Models\Carts\CartDiscounts;

use Domain\Orders\Actions\Cart\LoadCartById;
use Domain\Orders\Models\Carts\CartItems\CartItemDiscountAdvantage;
use Domain\Orders\Models\Carts\CartItems\CartItemDiscountCondition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Traits\BelongsTo\BelongsToCart;
use Support\Traits\BelongsTo\BelongsToDiscount;
use Support\Traits\HasModelUtilities;

class CartDiscount extends Model
{
    use HasFactory,
        HasModelUtilities,
        BelongsToCart,
        BelongsToDiscount;

    protected static function boot()
    {
        parent::boot();

        static::deleted(function (CartDiscount $cartDiscount) {
            $cartDiscount->clearCaches();
        });
    }

    public function clearCaches(): void
    {
        LoadCartById::now($this->cart_id)
            ->clearCaches();
    }

    public function codes(): HasMany
    {
        return $this->hasMany(
            CartDiscountCode::class,
            'cart_discount_id'
        );
    }

    public function advantages(): HasMany
    {
        return $this->hasMany(
            CartDiscountAdvantage::class,
            'cart_discount_id'
        );
    }

    public function itemAdvantages(): HasMany
    {
        return $this->hasMany(
            CartItemDiscountAdvantage::class,
            'cart_discount_id'
        );
    }

    public function itemConditions(): HasMany
    {
        return $this->hasMany(
            CartItemDiscountCondition::class,
            'cart_discount_id'
        );
    }
}
