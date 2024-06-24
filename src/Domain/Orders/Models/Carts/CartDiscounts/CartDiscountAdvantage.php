<?php

namespace Domain\Orders\Models\Carts\CartDiscounts;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Domain\Orders\Models\Carts\Cart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Support\Traits\HasModelUtilities;

class CartDiscountAdvantage extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'cart_discount_advantages';

    protected $fillable = [
        'cart_discount_id',
        'amount',
        'advantage_id',
    ];

    protected $casts = [
        'cart_discount_id' => 'int',
        'amount' => 'float',
        'advantage_id' => 'int',
    ];

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

    public function advantage(): BelongsTo
    {
        return $this->belongsTo(DiscountAdvantage::class);
    }

    public function cartDiscount()
    {
        return $this->belongsTo(CartDiscount::class);
    }

    public function discount()
    {
        return $this->hasOneThrough(
            Discount::class,
            DiscountAdvantage::class,
            'id',
            'id',
            'advantage_id',
            'discount_id',
        );
    }
}
