<?php

namespace Domain\Orders\Models\Checkout;

use Domain\Future\GiftRegistry\GiftRegistry;
use Domain\Orders\Actions\Checkout\LoadCheckoutById;
use Domain\Orders\Collections\CalculatedShippingRatesCollection;
use Domain\Orders\Dtos\Shipping\ShippingRateDto;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Support\Traits\BelongsTo\BelongsToDistributor;
use Support\Traits\BelongsTo\BelongsToShippingMethod;
use Support\Traits\ClearsCache;
use Support\Traits\HasModelUtilities;

class CheckoutShipment extends Model
{
    use HasFactory,
        HasModelUtilities,
        BelongsToDistributor,
        BelongsToShippingMethod,
        ClearsCache;

    protected $fillable = [
        'distributor_id',
        'registry_id',
        'shipping_method_id',
        'shipping_cost',
        'is_drop_ship',
        'is_digital',
        'latest_rates',
        'rated_at',
    ];

    protected $casts = [
        'distributor_id' => 'int',
        'registry_id' => 'int',
        'shipping_method_id' => 'int',
        'shipping_cost' => 'float',
        'is_drop_ship' => 'bool',
        'is_digital' => 'bool',
        'rated_at' => 'datetime',
        'latest_rates' => AsCollection::class . ':' . CalculatedShippingRatesCollection::class,
    ];

    private ?string $referenceId = null;

    protected function cacheTags(): array
    {
        return [
            "checkout-shipment-cache.{$this->id}",
            "checkout-shipments-cache.{$this->checkout_id}"
        ];
    }

    public function referenceId(): string
    {
        return $this->referenceId ??= implode(".", [
            'distributor_id' => $this->distributor_id,
            'registry_id' => $this->registry_id,
            'package_count' => $this->packages->count(),
            'is_digital' => $this->is_digital,
            'is_drop_ship' => $this->is_drop_ship,
        ]);
    }

    public function checkout(): BelongsTo
    {
        return $this->belongsTo(Checkout::class);
    }

    public function checkoutCached(): Checkout
    {
        return $this->checkout ??= LoadCheckoutById::now($this->checkout_id);
    }

    public function registry(): BelongsTo
    {
        return $this->belongsTo(GiftRegistry::class, 'registry_id');
    }

    public function packages(): HasMany
    {
        return $this->hasMany(CheckoutPackage::class, 'shipment_id');
    }

    public function items(): HasManyThrough
    {
        return $this->hasManyThrough(
            CheckoutItem::class,
            CheckoutPackage::class,
            'shipment_id',
            'package_id',
            'id',
            'id'
        );
    }

    public function needsNewRates(): bool
    {
        return $this->rated_at == null
            || $this->latest_rates->isEmpty()
            || $this->rated_at <= now()->subMinutes(5);
    }

    public function rates(): ?CalculatedShippingRatesCollection
    {
        return $this->latest_rates
            ?->map(
                fn (ShippingRateDto|array $rate) => is_array($rate)
                    ? ShippingRateDto::fromArray(
                        $rate
                    )
                    : $rate
            );
    }
}
