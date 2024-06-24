<?php

namespace Domain\Orders\Models\Order\OrderItems;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class OrdersProductsCustomsinfo
 *
 * @property int $orders_products_id
 * @property string $customs_description
 * @property float $customs_weight
 * @property float $customs_value
 *
 * @property OrderItem $orders_product
 *
 * @package Domain\Orders\Models\Product
 */
class OrderItemCustoms extends Model
{
    use HasModelUtilities;
    public $incrementing = false;
    protected $table = 'orders_products_customsinfo';
    protected $primaryKey = 'orders_products_id';

    protected $casts = [
        'orders_products_id' => 'int',
        'customs_weight' => 'int',
        'customs_value' => 'int',
    ];

    protected $fillable = [
        'customs_description',
        'customs_weight',
        'customs_value',
    ];

    public function value(): Attribute
    {
        return new Attribute(
            get: fn () => $this->attributes['customs_value']
        );
    }

    public function item()
    {
        return $this->belongsTo(OrderItem::class, 'orders_products_id');
    }

    public function calculateTotalValue(int $qty): int
    {
        return $this->value * $qty;
    }
}
