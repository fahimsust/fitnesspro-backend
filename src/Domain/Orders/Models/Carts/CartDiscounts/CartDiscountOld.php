<?php

namespace Domain\Orders\Models\Carts\CartDiscounts;

use Domain\Orders\Models\Carts\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;
use Worksome\RequestFactories\Concerns\HasFactory;

/**
 * Class SavedCartDiscount
 *
 * @property int $saved_cart_id
 * @property array $applied_codes_json
 * @property array $shipping_discounts_json
 * @property array $order_discounts_json
 * @property array $product_discounts_json
 *
 * @property Cart $saved_cart
 *
 * @package Domain\Orders\Models\SavedCarts
 */
class CartDiscountOld extends Model
{
    use HasModelUtilities,
        HasFactory;
    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'cart_discounts';
    protected $primaryKey = 'cart_id';

    protected $casts = [
        'cart_id' => 'int',
        'applied_codes_json' => 'json',
        'shipping_discounts_json' => 'json',
        'order_discounts_json' => 'json',
        'product_discounts_json' => 'json',
    ];

    protected $fillable = [
        'applied_codes_json',
        'shipping_discounts_json',
        'order_discounts_json',
        'product_discounts_json',
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }
}
