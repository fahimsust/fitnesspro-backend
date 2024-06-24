<?php

namespace Domain\Orders\Models\Order;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\LoyaltyPoints\PointsDebit;
use Domain\Addresses\Actions\LoadAddressById;
use Domain\Addresses\Models\Address;
use Domain\AdminUsers\Models\AdminEmailsSent;
use Domain\Affiliates\Models\Affiliate;
use Domain\Affiliates\Models\Referral;
use Domain\Discounts\Models\Discount;
use Domain\Future\GiftCards\GiftCardTransaction;
use Domain\Orders\Actions\Order\Transaction\LoadOrderTransactionsByOrderId;
use Domain\Orders\Enums\Order\OrderPaymentStatuses;
use Domain\Orders\Enums\Order\OrderStatuses;
use Domain\Orders\Models\Checkout\CheckoutDetails;
use Domain\Orders\Models\Checkout\CheckoutDiscount;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Orders\QueryBuilders\OrderQuery;
use Domain\Payments\Actions\LoadPaymentMethodById;
use Domain\Payments\Models\PaymentMethod;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Traits\BelongsTo\BelongsToAccount;
use Support\Traits\BelongsTo\BelongsToAffiliate;
use Support\Traits\BelongsTo\BelongsToCart;
use Support\Traits\BelongsTo\BelongsToSite;
use Support\Traits\ClearsCache;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Support\Traits\HasModelUtilities;
use Domain\Orders\Jobs\OrderCompleted;

class Order extends Model
{
    use HasFactory,
        HasModelUtilities,
        BelongsToCart,
        BelongsToAccount,
        BelongsToSite,
        BelongsToAffiliate,
        HasRelationships,
        ClearsCache;

    protected $guarded = ['id'];

    protected $casts = [
        'account_id' => 'int',
        'affiliate_id' => 'int',
        'billing_address_id' => 'int',
        'shipping_address_id' => 'int',
        'payment_method' => 'int',
        'payment_method_fee' => 'float',
        'addtl_discount' => 'float',
        'addtl_fee' => 'float',
        'site_id' => 'int',
        'cart_id' => 'int',
        'payment_status' => OrderPaymentStatuses::class,
        'status' => OrderStatuses::class,
        'archived' => 'bool',
        'inventory_order_id' => 'int',
    ];

    protected $fillable = [
        'order_no',
        'account_id',
        'billing_address_id',
        'shipping_address_id',
        'order_phone',
        'order_email',
        'payment_method',
        'payment_method_fee',
        'addtl_discount',
        'addtl_fee',
        'comments',
        'site_id',
        'cart_id',
        'archived',
        'payment_status',
        'status',
        'inventory_order_id',
        'affiliate_id',
    ];

    private ?float $subTotal = null;
    private ?float $shippingTotal = null;
    private ?float $discountTotal = null;
    private ?float $total = null;
    private ?float $referralTotal = null;
    private Address $billingAddressCached;
    private Address $shippingAddressCached;
    private \Illuminate\Support\Collection $transactionsCached;
    private PaymentMethod $paymentMethodCached;
    private Collection $itemsWithProductCached;

    public function newEloquentBuilder($query)
    {
        return new OrderQuery($query);
    }

    protected function cacheTags(): array
    {
        return [
            'order-cache.' . $this->id,
        ];
    }

    public function loyaltyDebits(): HasMany
    {
        return $this->hasMany(PointsDebit::class);
    }

    public function checkoutDiscounts(): HasMany
    {
        return $this->hasMany(CheckoutDiscount::class);
    }

    public function adminEmailsSent(): HasMany
    {
        return $this->hasMany(AdminEmailsSent::class);
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class);
    }

    public function giftCardTransactions(): HasMany
    {
        return $this->hasMany(GiftCardTransaction::class);
    }

    //  public function giftregistry_items_purchased()
    //  {
    //      return $this->hasOne(ItemPurchases::class);
    //  }

    public function activities(): HasMany
    {
        return $this->hasMany(OrderActivity::class);
    }
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function hasBillingAddress(): bool
    {
        return $this->billing_address_id > 0;
    }

    public function billingAddress(): BelongsTo
    {
        return $this->belongsTo(
            Address::class,
            'billing_address_id'
        );
    }

    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(
            Affiliate::class,
            'affiliate_id'
        );
    }

    public function billingAddressCached(): ?Address
    {
        if (!$this->hasBillingAddress()) {
            return null;
        }

        if ($this->relationLoaded('billingAddress')) {
            return $this->billingAddress;
        }

        return $this->billingAddressCached ??= LoadAddressById::now(
            $this->billing_address_id
        );
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(
            PaymentMethod::class,
            'payment_method'
        );
    }

    public function paymentMethodCached(): ?PaymentMethod
    {
        if (!$this->payment_method) {
            return null;
        }

        if ($this->relationLoaded('paymentMethod')) {
            return $this->paymentMethod;
        }

        return $this->paymentMethodCached ??= LoadPaymentMethodById::now(
            $this->payment_method
        );
    }

    public function hasShippingAddress(): bool
    {
        return $this->shipping_address_id > 0;
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
        if (!$this->hasShippingAddress()) {
            return null;
        }

        if ($this->relationLoaded('shippingAddress')) {
            return $this->shippingAddress;
        }

        return $this->shippingAddressCached ??= LoadAddressById::now(
            $this->shipping_address_id
        );
    }

    public function hasCart(): bool
    {
        return $this->cart_id > 0;
    }

    public function customForms(): HasMany
    {
        return $this->hasMany(
            OrderCustomForm::class
        );
    }


    public function discounts(): BelongsToMany
    {
        return $this->belongsToMany(
            Discount::class,
            OrderDiscount::class,
            'order_id',
            'discount_id'
        )
            ->withPivot('advantage_id', 'amount', 'id');
    }

    public function orderDiscounts(): HasMany
    {
        return $this->hasMany(OrderDiscount::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(OrderNote::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, );
    }

    public function itemsWithProduct(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            OrderItem::class,
            'order_id',
            'product_id'
        )
            ->withPivot(
                'id',
                'product_qty',
                'product_price',
                'product_notes',
                'product_saleprice',
                'product_onsale',
                'actual_product_id',
                'package_id',
                'parent_product_id',
                'product_label',
                'registry_item_id',
                'free_from_discount_advantage'
            );
    }
    public function rangeOption(): HasManyDeep
    {
        return $this->hasManyDeepFromRelations(
            $this->itemsWithProduct(),
            (new Product)->rangeOption()
        );
    }

    public function itemsWithProductCached(): Collection
    {
        if ($this->relationLoaded('itemsWithProduct')) {
            return $this->itemsWithProduct;
        }

        return $this->itemsWithProductCached
            ??= $this->itemsWithProduct()->get();
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(OrderTask::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(OrderTransaction::class);
    }

    public function transactionsCached(): Collection
    {
        if ($this->relationLoaded('transactions')) {
            return $this->transactions;
        }

        return $this->transactionsCached
            ??= LoadOrderTransactionsByOrderId::now($this->id);
    }

    public function checkoutDetails()
    {
        return $this->hasOne(CheckoutDetails::class);
    }

    public function activity(string $description): OrderActivity|Model
    {
        return $this->activities()
            ->create([
                'description' => $description,
                'created' => now()
            ]);
    }

    public function getNumberAttribute(): string
    {
        return $this->order_no;
    }

    public function subTotal(bool $useCache = false): float
    {
        if (!$useCache) {
            $this->subTotal = null;
        }

        return $this->subTotal ??= $this->shipments->reduce(
            fn(?float $carry, Shipment $shipment) => bcadd($carry, $shipment->subTotal()),
            0
        );
    }

    public function taxTotal(): float
    {
        return 0.00;
    }

    public function shippingTotal(bool $useCache = true): float
    {
        if (!$useCache) {
            $this->shippingTotal = null;
        }

        return $this->shippingTotal ??= $this->shipments->reduce(
            fn(?float $carry, Shipment $shipment) => bcadd($carry, $shipment->cost()),
            0
        );
    }

    public function discountTotal(bool $useCache = true): float
    {
        if (!$useCache) {
            $this->discountTotal = null;
        }

        return $this->discountTotal ??= $this->orderDiscounts->reduce(
            fn(?float $carry, OrderDiscount $orderDiscount) => bcadd(
                $carry,
                $orderDiscount->amount($this->subTotal())
            ),
            0
        );
    }

    public function total(bool $useCache = true): float
    {
        if ($useCache && $this->total !== null) {
            $this->total = null;
        }

        $subTotalShipping = bcadd($this->subTotal($useCache), $this->shippingTotal($useCache));
        $subTotalShippingTax = bcadd($subTotalShipping, $this->taxTotal());

        $fees = bcadd($this->addtl_fee, $this->payment_method_fee);
        $subTotalShippingTaxFees = bcadd($subTotalShippingTax, $fees);

        $totalDiscount = bcadd($this->discountTotal(), $this->addtl_discount);

        return $this->total = bcsub(
            $subTotalShippingTaxFees,
            $totalDiscount
        );
    }

    public function referralTotal(bool $useCache = true): float
    {
        if (!$useCache) {
            $this->referralTotal = null;
        }

        return $this->referralTotal ??= $this->referrals->reduce(
            fn(?float $carry, Referral $referral) => bcadd($carry, $referral->amount),
            0
        );
    }
}
