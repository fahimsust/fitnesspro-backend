<?php

namespace Domain\Orders\Models\Carts\CartItems;

use Domain\Discounts\Enums\OnSaleStatuses;
use Domain\Future\GiftRegistry\RegistryItem;
use Domain\Products\Actions\Product\LoadProductByIdFromCache;
use Domain\Products\Models\Product\AccessoryField\AccessoryField;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Support\Traits\BelongsTo\BelongsToCart;
use Support\Traits\BelongsTo\BelongsToDistributor;
use Support\Traits\BelongsTo\BelongsToProduct;
use Support\Traits\ClearsCache;
use Support\Traits\HasModelUtilities;

class CartItem extends Model
{
    use HasModelUtilities,
        HasFactory,
        BelongsToProduct,
        BelongsToDistributor,
        BelongsToCart,
        ClearsCache {
        ClearsCache::boot as clearCacheBoot;
    }

    public $timestamps = false;

    protected $casts = [
        'cart_id' => 'int',
        'product_id' => 'int',
        'parent_product' => 'int',
        'parent_cart_item_id' => 'int',
        'required' => 'int',
        'qty' => 'int',
        'price_reg' => 'float',
        'price_sale' => 'float',
        'onsale' => 'bool',
        'registry_item_id' => 'int',
        'accessory_field_id' => 'int',
        'distributor_id' => 'int',
        'accessory_link_actions' => 'int',
    ];

    protected $fillable = [
        'cart_id',
        'product_id',
        'parent_product',
        'parent_cart_item_id',
        'required',
        'qty',
        'price_reg',
        'price_sale',
        'onsale',
        'product_label',
        'registry_item_id',
        'accessory_field_id',
        'distributor_id',
        'accessory_link_actions',
    ];

    protected static function boot()
    {
        static::clearCacheBoot();

        static::created(function (CartItem $item) {
            $item->clearCaches();
        });
    }

    protected function cacheTags(): array
    {
        return [
            "cart-items-cache.{$this->cart_id}",
            "cart-item-cache.{$this->id}"
        ];
    }

    public function accessoryField(): BelongsTo
    {
        return $this->belongsTo(
            AccessoryField::class,
            'accessory_field_id'
        );
    }

    public function parentProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'parent_product');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function parentProductCached(): ?Product
    {
        if (!$this->parent_product) {
            return null;
        }

        return $this->parentProduct ??= LoadProductByIdFromCache::now($this->parent_product);
    }

    public function registryItem(): BelongsTo
    {
        return $this->belongsTo(RegistryItem::class);
    }

    public function customFields(): HasMany
    {
        return $this->hasMany(
            CartItemCustomField::class,
            'item_id'
        );
    }

    public function optionValues(): HasMany
    {
        return $this->hasMany(
            CartItemOption::class,
            'item_id'
        );
    }

    //    public function optionCustomValues(): HasManyThrough
    //    {
    //        return $this->hasManyThrough(
    //            CartItemOptionCustomValueUNUSED::class,
    //            CartItemOption::class,
    //            'item_id'
    //        );
    //    }

    public function parentItem(): BelongsTo
    {
        return $this->belongsTo(CartItem::class, 'parent_cart_item_id');
    }

    public function childrenItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'parent_cart_item_id');
    }

    public function requiredFor(): BelongsTo
    {
        return $this->belongsTo(CartItem::class, 'required');
    }

    public function accessoryLinkedActionItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'accessory_link_actions');
    }

    public function discountAdvantages(): HasMany
    {
        return $this->hasMany(CartItemDiscountAdvantage::class, 'item_id');
    }

    public function discountConditions(): HasMany
    {
        return $this->hasMany(CartItemDiscountCondition::class, 'item_id');
    }

    public function hasOrderingRule(): bool
    {
        return $this->product->ordering_rule_id;
    }

    public function hasCustomFields(): bool
    {
        return (bool)$this->customFields->count();
    }

    public function unitPrice(): float
    {
        return $this->onsale === true
            ? $this->price_sale
            : $this->price_reg;
    }

    public function subTotal(): float
    {
        return bcmul($this->unitPrice(), $this->qty);
    }

    public function totalAmount(): float
    {
        return $this->subTotal()
            - $this->discountTotal();
    }

    public function discountTotal(): float
    {
        return $this->discountAdvantages()
            ->withWhereHas(
                'discount',
                fn(Builder $query) => $query->active()
            )
            ->sum(DB::raw('qty * amount'));
    }

    public function weightTotal(): float
    {
        return bcmul($this->qty, $this->loadMissingReturn('product')->weight());
    }

    public function isProduct(Product $product): bool
    {
        return $this->product_id === $product->id
            || $this->parent_product === $product->id;
    }

    public function isProductType(ProductType $type): bool
    {
        return $this->loadMissingReturn('product.details')->type_id;
    }

    public function isAutoAdded(): bool
    {
        return (bool)$this->free_from_discount_advantage;
    }

    public function isFreeItem(): bool
    {
        return $this->isAutoAdded() && $this->price <= 0;
    }

    public function isRegistryItem(): bool
    {
        return (bool)$this->registry_item_id;
    }

    public function showQtyField(): bool
    {
        return !$this->isAutoAdded()
            && $this->required === 0
            && !($this->accessory_link_actions > 0);
    }

    public function showDelete(): bool
    {
        return $this->required === 0
            && !$this->isAutoAdded()
            && !($this->accessory_link_actions > 0);
    }

    public function showQtyUpdateField(): bool
    {
        return !$this->isAutoAdded()
            && ($this->max_qty === 0 || $this->max_qty > 1);
    }

    public function showDownloadLink(): bool
    {
        return $this->downloadable === 1
            && $this->downloadable_file !== '';
    }

    public function onSaleStatus(): OnSaleStatuses
    {
        return $this->onsale
            ? OnSaleStatuses::OnSale
            : OnSaleStatuses::NotOnSale;
    }
}
