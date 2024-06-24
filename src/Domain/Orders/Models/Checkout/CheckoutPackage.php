<?php

namespace Domain\Orders\Models\Checkout;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Traits\HasModelUtilities;

class CheckoutPackage extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $fillable = [
        'shipment_id'
    ];

    protected $casts = [
        'shipment_id' => 'int',
    ];

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(
            CheckoutShipment::class,
            'shipment_id'
        );
    }

    public function items(): HasMany
    {
        return $this->hasMany(
            CheckoutItem::class,
            'package_id',
        );
    }
}
