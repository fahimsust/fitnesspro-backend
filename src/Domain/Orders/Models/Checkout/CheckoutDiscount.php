<?php

namespace Domain\Orders\Models\Checkout;

use Domain\Discounts\Models\Discount;
use Domain\Orders\Models\Order\Order;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SavedOrderDiscount
 *
 * @property int $order_id
 * @property int $discount_id
 * @property string $discount_code
 *
 * @property Discount $discount
 * @property Order $order
 *
 * @package Domain\Orders\Models\SavedOrders
 */
class CheckoutDiscount extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'saved_order_discounts';

    protected $casts = [
        'order_id' => 'int',
        'discount_id' => 'int',
    ];

    protected $fillable = [
        'order_id',
        'discount_id',
        'discount_code',
    ];

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
