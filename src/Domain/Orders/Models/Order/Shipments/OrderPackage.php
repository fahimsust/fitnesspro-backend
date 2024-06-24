<?php

namespace Domain\Orders\Models\Order\Shipments;

use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Traits\HasModelUtilities;

class OrderPackage extends Model
{
    use HasFactory,
        HasModelUtilities;

    public $timestamps = false;

    protected $table = 'orders_packages';

    protected $casts = [
        'shipment_id' => 'int',
        'package_type' => 'int',
        'package_size' => 'int',
        'is_dryice' => 'bool',
        'dryice_weight' => 'float',
    ];

    protected $fillable = [
        'shipment_id',
        'package_type',
        'package_size',
        'is_dryice',
        'dryice_weight',
    ];

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(
            Shipment::class,
            'shipment_id'
        );
    }

    public function items(): HasMany
    {
        return $this->hasMany(
            OrderItem::class,
            'package_id'
        );
    }

    public function labels(): HasMany
    {
        return $this->hasMany(
            ShipmentLabel::class,
            'package_id'
        );
    }

    public function subTotal(): float
    {
        return $this->items->reduce(
            fn(?float $carry, OrderItem $item) => bcadd($carry, $item->subTotal()),
            0
        );
    }
}
