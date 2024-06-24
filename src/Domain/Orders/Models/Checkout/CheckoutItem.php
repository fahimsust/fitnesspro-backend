<?php

namespace Domain\Orders\Models\Checkout;

use Domain\Discounts\Models\Discount;
use Domain\Orders\Actions\Cart\Item\LoadCartItemById;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Traits\HasModelUtilities;

class CheckoutItem extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $fillable = [
        'product_id',
        'cart_item_id',
        'qty'
    ];

    protected $casts = [
        'package_id' => 'int',
        'product_id' => 'int',
        'cart_item_id' => 'int',
        'qty' => 'int',
    ];

    public ?CartItem $cartItemCached = null;

    public function package(): BelongsTo
    {
        return $this->belongsTo(
            CheckoutPackage::class,
            'package_id'
        );
    }

    public function checkoutDiscounts(): HasMany
    {
        return $this->hasMany(
            CheckoutItemDiscount::class,
            'checkout_item_id',
        );
    }
    public function discounts()
    {
        return $this->belongsToMany(
            Discount::class,
            CheckoutItemDiscount::class,
            'checkout_item_id',
            'discount_id'
        )
            ->withPivot('advantage_id', 'amount', 'qty', 'id');
    }

    public function cartItem(): BelongsTo
    {
        return $this->belongsTo(
            CartItem::class,
            'cart_item_id',
        );
    }

    public function cartItemCached(): CartItem
    {
        if ($this->relationLoaded('cartItem')) {
            return $this->cartItem;
        }

        return $this->cartItemCached ??= LoadCartItemById::now($this->cart_item_id);
    }
}
