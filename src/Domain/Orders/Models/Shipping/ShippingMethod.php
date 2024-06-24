<?php

namespace Domain\Orders\Models\Shipping;

use Domain\Distributors\Models\Distributor;
use Domain\Distributors\Models\Shipping\DistributorShippingMethod;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\ClearsCache;
use Support\Traits\HasModelUtilities;

/**
 * Class ShippingMethod
 *
 * @property int $id
 * @property string $name
 * @property string $display
 * @property string $refname
 * @property string $carriercode
 * @property bool $status
 * @property float $price
 * @property int $rank
 * @property int $ships_residential
 * @property int $carrier_id
 * @property float $weight_limit
 * @property float $weight_min
 * @property bool $is_international
 *
 * @property ShippingCarrier $shipping_carrier
 * @property Collection|array<Distributor> $distributors
 * @property Collection|array<Shipment> $orders_shipments
 *
 * @package Domain\Orders\Models\Shipping
 */
class ShippingMethod extends Model
{
    use HasFactory,
        HasModelUtilities,
        ClearsCache;

    public $timestamps = false;

    protected $casts = [
        'status' => 'bool',
        'price' => 'float',
        'rank' => 'int',
        'ships_residential' => 'int',
        'carrier_id' => 'int',
        'weight_limit' => 'float',
        'weight_min' => 'float',
        'is_international' => 'bool',
    ];

    protected $fillable = [
        'name',
        'display',
        'refname',
        'carriercode',
        'status',
        'price',
        'rank',
        'ships_residential',
        'carrier_id',
        'weight_limit',
        'weight_min',
        'is_international',
    ];

    protected function cacheTags(): array
    {
        return [
            "shipping-method-cache.{$this->id}"
        ];
    }

    public function label(): string
    {
        if ($this->display == "") {
            return $this->name;
        }

        return $this->display ?? $this->name;
    }

    public function carrier(): BelongsTo
    {
        return $this->belongsTo(
            ShippingCarrier::class,
            'carrier_id'
        );
    }

    public function distributors()
    {
        //todo
        return $this->hasManyThrough(
            Distributor::class,
            DistributorShippingMethod::class,
        )
            ->withPivot('id', 'status', 'flat_price', 'flat_use', 'handling_fee', 'handling_percentage', 'call_for_estimate', 'discount_rate', 'display', 'override_is_international');
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class, 'ship_method_id');
    }
}
