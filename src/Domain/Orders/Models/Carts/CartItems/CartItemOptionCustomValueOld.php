<?php

namespace Domain\Orders\Models\Carts\CartItems;

use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SavedCartItemsOptionsCustomvalue
 *
 * @property int $saved_cart_item_id
 * @property int $option_id
 * @property string $custom_value
 *
 * @property ProductOptionValue $products_options_value
 * @property CartItem $saved_cart_item
 *
 * @package Domain\Orders\Models\SavedCarts
 */
class CartItemOptionCustomValueOld extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'saved_cart_items_options_customvalues';

    protected $casts = [
        'saved_cart_item_id' => 'int',
        'option_id' => 'int',
    ];

    protected $fillable = [
        'custom_value',
    ];

    public function optionValue()
    {
        return $this->belongsTo(
            ProductOptionValue::class,
            'option_id'
        );
    }

    public function option()
    {
        //todo
        return $this->hasOneThrough(
            ProductOption::class,
            ProductOptionValue::class,
        );
    }

    public function cartItem()
    {
        return $this->belongsTo(CartItem::class);
    }
}
