<?php

namespace Domain\Orders\Models\Order;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class OrdersDiscount
 *
 * @property int $order_id
 * @property int $discount_id
 * @property string $amount
 * @property int $advantage_id
 * @property int $id
 *
 * @property DiscountAdvantage $discount_advantage
 * @property Discount $discount
 * @property Order $order
 *
 * @package Domain\Orders\Models
 */
class OrderDiscount extends Model
{
    use HasModelUtilities, HasFactory;
    protected $table = 'orders_discounts';

    protected $casts = [
        'order_id' => 'int',
        'discount_id' => 'int',
        'advantage_id' => 'int',
    ];

    protected $fillable = [
        'order_id',
        'discount_id',
        'amount',
        'advantage_id',
    ];

    public function advantage(): BelongsTo
    {
        return $this->belongsTo(
            DiscountAdvantage::class,
            'advantage_id'
        );
    }

    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function amount(float $orderSubTotal): float
    {
        if ($this->amount == "FREE") {
            return $orderSubTotal;
        }

        if (\Str::contains($this->amount, '%')) {
            $percentage = \Str::replace('%', '', $this->amount);
            return bcmul($orderSubTotal, bcdiv($percentage, 100));
        }

        return (float) $this->amount;
    }
}
