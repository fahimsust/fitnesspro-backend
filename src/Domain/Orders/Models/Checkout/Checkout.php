<?php

namespace Domain\Orders\Models\Checkout;

use Cache;
use Domain\Accounts\Models\Account;
use Domain\Addresses\Actions\LoadAddressById;
use Domain\Addresses\Models\Address;
use Domain\Orders\Enums\Checkout\CheckoutStatuses;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\QueryBuilders\CheckoutQuery;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Str;
use Support\Traits\BelongsTo\BelongsToAccount;
use Support\Traits\BelongsTo\BelongsToAffiliate;
use Support\Traits\BelongsTo\BelongsToCart;
use Support\Traits\BelongsTo\BelongsToOrder;
use Support\Traits\BelongsTo\BelongsToPaymentMethod;
use Support\Traits\BelongsTo\BelongsToSite;
use Support\Traits\ClearsCache;
use Support\Traits\HasModelUtilities;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Checkout extends Model
{
    use HasFactory,
        HasModelUtilities,
        BelongsToCart,
        HasRelationships,
        BelongsToSite,
        BelongsToAccount,
        BelongsToAffiliate,
        BelongsToOrder,
        BelongsToPaymentMethod;

    use ClearsCache {
        ClearsCache::boot as clearCacheBoot;
    }

    protected $fillable = [
        'cart_id',
        'site_id',
        'account_id',
        'affiliate_id',
        'order_id',
        'billing_address_id',
        'shipping_address_id',
        'payment_method_id',
        'comments'
    ];

    protected $casts = [
        'uuid' => 'string',
        'cart_id' => 'int',
        'site_id' => 'int',
        'account_id' => 'int',
        'affiliate_id' => 'int',
        'order_id' => 'int',
        'billing_address_id' => 'int',
        'shipping_address_id' => 'int',
        'payment_method_id' => 'int',
        'status' => CheckoutStatuses::class,
    ];

    private Collection $shipmentsCached;
    private Address $billingAddressCached;
    private Address $shippingAddressCached;
    private float $shippingCostCached;

    public function newEloquentBuilder($query)
    {
        return new CheckoutQuery($query);
    }

    protected static function boot()
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });

        static::clearCacheBoot();
    }

    protected function cacheTags(): array
    {
        return [
            "checkout-cache.{$this->id}",
            "checkout-uuid-cache.{$this->uuid}",
            "checkout-shipments-cache.{$this->id}",
        ];
    }

    public function billingAddress(): BelongsTo
    {
        return $this->belongsTo(
            Address::class,
            'billing_address_id'
        );
    }
    public function site(): BelongsTo
    {
        return $this->belongsTo(
            Site::class
        );
    }
    public function account(): BelongsTo
    {
        return $this->belongsTo(
            Account::class
        );
    }
    public function order(): BelongsTo
    {
        return $this->belongsTo(
            Order::class
        );
    }

    public function billingAddressCached(): ?Address
    {
        if (!$this->billing_address_id) {
            return null;
        }

        if ($this->relationLoaded('billingAddress')) {
            return $this->billingAddress;
        }

        $this->billingAddressCached
            ??= LoadAddressById::now($this->billing_address_id);

        $this->setRelation(
            'billingAddress',
            $this->billingAddressCached
        );

        return $this->billingAddressCached;
    }

    public function shippingAddress(): BelongsTo
    {
        return $this->belongsTo(
            Address::class,
            'shipping_address_id'
        );
    }

    public function shippingAddressCached(): ?Address
    {
        if (!$this->shipping_address_id) {
            return null; 
        }


        if ($this->relationLoaded('billingAddress')) {
            return $this->shippingAddress;
        }

        $this->shippingAddressCached
            ??= LoadAddressById::now($this->shipping_address_id);

        $this->setRelation(
            'shippingAddress',
            $this->shippingAddressCached
        );

        return $this->shippingAddressCached;
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(CheckoutShipment::class);
    }

    public function items():HasManyDeep
    {
        return $this->hasManyDeepFromRelations(
            $this->shipments(),
            (new CheckoutShipment)->items()
        );
    }

    public function shipmentsCached(): Collection           
    {
        if ($this->relationLoaded('shipments')) {
            return $this->shipments
                ->loadMissing([
                    'registry',
                    'shippingMethod',
                    'packages' => fn($query) => $query->with([
                        'items' => fn($query) => $query->with([
                            'cartItem' => fn($query) => $query->with([
                                'product.defaultAvailability',
                                'parentItem',
                                'customFields',
                                'registryItem',
                                'discountAdvantages',
                            ]),
                            'discounts',
                        ]),
                    ]),
                ]);
        }

        $this->shipmentsCached ??= Cache::tags([
            "checkout-shipments-cache.{$this->id}",
        ])
            ->remember(
                "load-checkout-shipments.{$this->id}",
                60 * 30,
                fn() => $this->shipments()
                    ->with([
                        'registry',
                        'shippingMethod',
                        'packages' => fn($query) => $query->with([
                            'items' => fn($query) => $query->with([
                                'cartItem' => fn($query) => $query->with([
                                    'product.defaultAvailability',
                                    'parentItem',
                                    'customFields',
                                    'registryItem',
                                    'discountAdvantages',
                                ]),
                                'discounts',
                            ]),
                        ]),
                    ])
                    ->get()
            );

        $this->setRelation('shipments', $this->shipmentsCached);

        return $this->shipmentsCached;
    }

    public function shippingCost(): float
    {
        return $this->shippingCostCached ??= $this->loadMissingReturn('shipments')
            ->reduce(
                fn(?float $carry, CheckoutShipment $shipment) => bcadd(
                    $carry,
                    $shipment->shipping_cost
                ),
                0
            );
    }

    public function taxTotal(): float
    {
        return 0;
    }

    public function total(): float
    {
        return collect([
            $this->cartCached()->total(),
            $this->taxTotal(),
            $this->shippingCost(),
            $this->paymentMethodCached()?->fee ?? 0,
        ])
            ->reduce(
                fn(?float $carry, float $item) => bcadd(
                    $carry,
                    $item
                ),
                0
            );
    }
}
