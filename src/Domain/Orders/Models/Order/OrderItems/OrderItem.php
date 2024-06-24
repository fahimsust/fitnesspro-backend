<?php

namespace Domain\Orders\Models\Order\OrderItems;

use Domain\Discounts\Models\Discount;
use Domain\Future\GiftRegistry\RegistryItem;
use Domain\Orders\Models\Carts\CartItems\CartItemOption;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Products\Actions\Product\LoadProductByIdFromCache;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Trips\Models\TripFlyer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;
use Support\Traits\BelongsTo\BelongsToOrder;
use Support\Traits\BelongsTo\BelongsToProduct;
use Support\Traits\ClearsCache;
use Illuminate\Support\Facades\DB;
use Support\Traits\HasModelUtilities;

class OrderItem extends Model
{
    use HasFactory,
        HasModelUtilities,
        BelongsToOrder,
        BelongsToProduct,
        ClearsCache;

    protected $table = 'orders_products';

    protected $casts = [
        'order_id' => 'int',
        'product_id' => 'int',
        'product_qty' => 'int',
        'product_price' => 'int',
        'product_saleprice' => 'int',
        'product_onsale' => 'bool',
        'actual_product_id' => 'int',
        'package_id' => 'int',
        'parent_product_id' => 'int',
        'cart_id' => 'int',
        'registry_item_id' => 'int',
        'free_from_discount_advantage' => 'int',
    ];

    protected $fillable = [
        'order_id',
        'product_id',
        'product_qty',
        'product_price',
        'product_notes',
        'product_saleprice',
        'product_onsale',
        'actual_product_id',
        'package_id',
        'parent_product_id',
        'cart_id',
        'product_label',
        'registry_item_id',
        'free_from_discount_advantage',
    ];

    private Product $parentProductCached;

    protected function cacheTags(): array
    {
        return [
            "order-item-cache.{$this->id}",
            "order-cache.{$this->order_id}"
        ];
    }

    public function parentProduct(): BelongsTo
    {
        return $this->belongsTo(
            Product::class,
            'parent_product_id',
            'id'
        );
    }

    public function parentProductCached(): ?Product
    {
        if ($this->hasParent() === false) {
            return null;
        }

        return $this->parentProductCached ??= LoadProductByIdFromCache::now(
            $this->parent_product_id
        );
    }

    public function hasParent(): bool
    {
        return !is_null($this->parent_product_id);
    }
    public function productDetailsParent(): HasOne
    {
        return $this->hasOne(
            ProductDetail::class,
            'product_id',
            'parent_product_id'
        );
    }

    public function productDetails(): HasOne
    {
        if ($this->hasParent()) {
            return $this->hasOne(
                ProductDetail::class,
                'product_id',
                'parent_product_id'
            );
        }

        return $this->hasOne(
            ProductDetail::class,
            'product_id',
            'product_id'
        );
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(
            OrderPackage::class,
            'package_id'
        );
    }

    public function registryItem(): BelongsTo
    {
        return $this->belongsTo(
            RegistryItem::class,
            'registry_item_id'
        );
    }

    //  public function giftregistry_items_purchased()
    //  {
    //      return $this->hasOne(ItemPurchases::class, 'order_product_id');
    //  }

    public function tripFlyer()
    {
        return $this->hasOne(
            TripFlyer::class,
            'orders_products_id'
        );
    }

    public function customFields()
    {
        return $this->hasMany(
            OrderItemCustomField::class,
            'orders_products_id'
        );
    }

    public function customs()
    {
        return $this->hasOne(
            OrderItemCustoms::class,
            'orders_products_id'
        );
    }
    public function orderItemDiscounts()
    {
        return $this->hasMany(
            OrderItemDiscount::class,
            'orders_products_id'
        );
    }

    public function discounts()
    {
        return $this->belongsToMany(
            Discount::class,
            OrderItemDiscount::class,
            'orders_products_id',
            'discount_id'
        )
            ->withPivot('advantage_id', 'amount', 'qty', 'id');
    }

    public function options()
    {
        return $this->hasMany(
            OrderItemOptionOld::class,
            'orders_products_id'
        );
    }

    public function optionValues(): HasMany
    {
        return $this->hasMany(
            OrderItemOption::class,
            'item_id'
        );
    }

    public function sentEmails()
    {
        return $this->hasMany(
            OrderItemSentEmail::class,
            'orders_products_id'
        );
    }

    public function calculateCustomsValueTotal(): int
    {
        return $this->customs->calculateTotalValue($this->qty);
    }

    public function getLabelAttribute(): string
    {
        return $this->product_label;
    }

    public function getPriceAttribute(): float
    {
        return $this->product_onsale
            ? $this->product_saleprice
            : $this->product_price;
    }
    public function subTotal(): float
    {
        $orderSubTotal = bcmul($this->product_qty, $this->price);
        foreach ($this->orderItemDiscounts as $discount) {
            $orderSubTotal -= $discount->getTotalDisplay($orderSubTotal, $this->product_qty);
        }

        return $orderSubTotal;
    }
}
