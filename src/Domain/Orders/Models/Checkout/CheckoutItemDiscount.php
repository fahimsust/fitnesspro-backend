<?php

namespace Domain\Orders\Models\Checkout;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\BelongsTo\BelongsToDiscount;
use Support\Traits\HasModelUtilities;

class CheckoutItemDiscount extends Model
{
    use HasFactory,
        HasModelUtilities,
        BelongsToDiscount;

    protected $fillable = [
        'advantage_id',
        'discount_id',
        'qty',
        'amount'
    ];

    protected $casts = [
        'checkout_item_id' => 'int',
        'advantage_id' => 'int',
        'discount_id' => 'int',
        'qty' => 'int',
        'amount' => 'string',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(
            CheckoutItem::class,
            'checkout_item_id'
        );
    }

    public function advantage(): BelongsTo
    {
        return $this->belongsTo(
            DiscountAdvantage::class,
            'advantage_id'
        );
    }

    public function discount(): BelongsTo
    {
        return $this->belongsTo(
            Discount::class,
            'discount_id',
        );
    }
}
