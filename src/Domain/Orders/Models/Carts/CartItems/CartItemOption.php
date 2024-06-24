<?php

namespace Domain\Orders\Models\Carts\CartItems;

use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Support\Traits\HasModelUtilities;

class CartItemOption extends Model
{
    use HasFactory, HasModelUtilities;

    protected $table = 'cart_item_options';

    protected $casts = [
        'custom_value' => 'array',
    ];

    protected $attributes = [
        'custom_value' => '[]',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(CartItem::class, 'item_id');
    }

    public function optionValue(): BelongsTo
    {
        return $this->belongsTo(ProductOptionValue::class);
    }

    public function option(): HasOneThrough
    {
        return $this->hasOneThrough(
            ProductOption::class,
            ProductOptionValue::class,
            'id',
            'id',
            'option_value_id',
            'option_id'
        );
    }

//    public function customValue()
//    {
//        return $this->hasOne(
//            CartItemOptionCustomValue::class,
//            'item_option_id'
//        );
//    }
}
