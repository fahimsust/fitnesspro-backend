<?php

namespace Domain\Orders\Models\Order\OrderItems;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class OrdersProductsDiscount
 *
 * @property int $orders_products_id
 * @property int $discount_id
 * @property int $advantage_id
 * @property string $amount
 * @property int $qty
 * @property int $id
 *
 * @property DiscountAdvantage $discount_advantage
 * @property Discount $discount
 * @property OrderItem $orders_product
 *
 * @package Domain\Orders\Models\Product
 */
class OrderItemDiscount extends Model
{

    use HasFactory, HasModelUtilities;
    protected $table = 'orders_products_discounts';

    protected $casts = [
        'orders_products_id' => 'int',
        'discount_id' => 'int',
        'advantage_id' => 'int',
        'qty' => 'int',
    ];

    protected $fillable = [
        'orders_products_id',
        'discount_id',
        'advantage_id',
        'amount',
        'qty',
    ];

    public function advantage()
    {
        return $this->belongsTo(
            DiscountAdvantage::class,
            'advantage_id'
        );
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function item()
    {
        return $this->belongsTo(
            OrderItem::class,
            'orders_products_id'
        );
    }
    public function getTotalDisplay(float $orderSubTotal, int $qty = 1): float
    {
        if ($this->amount == "FREE") {
            return $orderSubTotal * $qty;
        }

        if (\Str::contains($this->amount, '%')) {
            $percentage = \Str::replace('%', '', $this->amount);
            return bcmul($orderSubTotal, bcdiv($percentage, 100)) * $qty * $this->qty;
        }

        return (float) $this->amount * $this->qty;
    }
}
