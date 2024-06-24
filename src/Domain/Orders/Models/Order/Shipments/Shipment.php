<?php

namespace Domain\Orders\Models\Order\Shipments;

use Domain\Accounts\Models\LoyaltyPoints\PointsCredit;
use Domain\Distributors\Models\Distributor;
use Domain\Distributors\Models\Inventory\GatewayOrder;
use Domain\Future\GiftRegistry\GiftRegistry;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Shipping\ShippingMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Support\Traits\BelongsTo\BelongsToOrder;
use Support\Traits\HasModelUtilities;

class Shipment extends Model
{
    use HasFactory,
        HasModelUtilities,
        HasRelationships,
        BelongsToOrder;

    public $timestamps = false;

    protected $table = 'orders_shipments';

    protected $casts = [
        'order_id' => 'int',
        'distributor_id' => 'int',
        'ship_method_id' => 'int',
        'order_status_id' => 'int',
        'is_downloads' => 'bool',
        'saturday_delivery' => 'bool',
        'alcohol' => 'bool',
        'dangerous_goods' => 'bool',
        'dangerous_goods_accessibility' => 'bool',
        'hold_at_location' => 'bool',
        'signature_required' => 'int',
        'cod' => 'bool',
        'cod_amount' => 'int',
        'cod_currency' => 'int',
        'insured' => 'bool',
        'insured_value' => 'int',
        'archived' => 'bool',
        'registry_id' => 'int',
        'ship_date' => 'datetime',
        'future_ship_date' => 'datetime',
        'delivery_date' => 'datetime',
        'last_status_update' => 'datetime',
    ];

    protected $fillable = [
        'order_id',
        'distributor_id',
        'ship_method_id',
        'order_status_id',
        'ship_tracking_no',
        'ship_cost',
        'ship_date',
        'future_ship_date',
        'delivery_date',
        'signed_for_by',
        'is_downloads',
        'last_status_update',
        'saturday_delivery',
        'alcohol',
        'dangerous_goods',
        'dangerous_goods_accessibility',
        'hold_at_location',
        'hold_at_location_address',
        'signature_required',
        'cod',
        'cod_amount',
        'cod_currency',
        'insured',
        'insured_value',
        'archived',
        'inventory_order_id',
        'registry_id',
    ];

    public function distributor(): BelongsTo
    {
        return $this->belongsTo(Distributor::class);
    }

    public function status()
    {
        return $this->belongsTo(
            ShipmentStatus::class,
            'order_status_id'
        );
    }

    public function registry(): BelongsTo
    {
        return $this->belongsTo(
            GiftRegistry::class,
            'registry_id'
        );
    }

    public function shippingMethod()
    {
        return $this->belongsTo(
            ShippingMethod::class,
            'ship_method_id'
        );
    }

    public function loyaltyCredits()
    {
        return $this->hasMany(
            PointsCredit::class,
            'shipment_id'
        );
    }

    public function inventoryGatewayOrders()
    {
        return $this->hasMany(GatewayOrder::class, 'shipment_id');
    }

    public function labels()
    {
        return $this->hasMany(
            ShipmentLabel::class,
            'shipment_id'
        );
    }

    public function items(): HasManyDeep
    {
        return $this->hasManyDeepFromRelations(
            $this->packages(),
            (new OrderPackage)->items()
        );
    }

    public function packages(): HasMany
    {
        return $this->hasMany(
            OrderPackage::class,
            'shipment_id'
        );
    }

    public function subTotal(): float
    {
        return $this->packages->reduce(
            fn(?float $carry, OrderPackage $package) => bcadd($carry, $package->subTotal()),
            0
        );
    }

    public function cost(): float
    {
        return $this->ship_cost;
    }
}
