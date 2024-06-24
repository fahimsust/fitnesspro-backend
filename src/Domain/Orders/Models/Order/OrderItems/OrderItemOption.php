<?php

namespace Domain\Orders\Models\Order\OrderItems;

use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class OrderItemOption extends Model
{
    use HasFactory, HasModelUtilities;

    public $timestamps = false;

    protected $table = 'order_item_options';

    protected $casts = [
        'custom_value' => 'array',
    ];

    protected $attributes = [
        'custom_value' => '[]',
    ];

    public function item()
    {
        return $this->belongsTo(OrderItem::class, 'item_id');
    }

    public function optionValue()
    {
        return $this->belongsTo(ProductOptionValue::class);
    }

    public function option()
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
}
