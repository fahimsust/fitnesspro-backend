<?php

namespace Domain\Orders\Models\Carts\CartItems;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SavedCartItemsOption
 *
 * @property int $saved_cart_item_id
 * @property array $options_json
 *
 * @property CartItem $saved_cart_item
 *
 * @package Domain\Orders\Models\SavedCarts
 */
class CartItemOptionOld extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'cart_items_options';
    protected $primaryKey = 'cart_item_id';

    protected $casts = [
        'cart_item_id' => 'int',
        'options_json' => 'json',
    ];

    protected $fillable = [
        'options_json',
    ];

    public function cartItem()
    {
        return $this->belongsTo(CartItem::class);
    }
}
