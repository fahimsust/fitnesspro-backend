<?php

namespace Domain\Orders\Models\Carts\CartItems;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Support\Traits\HasModelUtilities;

class CartItemDiscountAdvantage extends Model
{
    use HasFactory,
        HasModelUtilities;

    public function item(): BelongsTo
    {
        return $this->belongsTo(CartItem::class);
    }

    public function advantage(): BelongsTo
    {
        return $this->belongsTo(DiscountAdvantage::class);
    }

    public function cartDiscount()
    {
        return $this->belongsTo(CartDiscount::class);
    }

    public function discount(): HasOneThrough
    {
        return $this->hasOneThrough(
            Discount::class,
            DiscountAdvantage::class,
            'id',
            'id',
            'advantage_id',
            'discount_id'
        );
    }
}
