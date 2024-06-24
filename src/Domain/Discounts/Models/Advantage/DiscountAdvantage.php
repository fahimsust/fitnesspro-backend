<?php

namespace Domain\Discounts\Models\Advantage;

use Domain\Accounts\Models\AccountAddress;
use Domain\Discounts\Enums\ApplyQtyTypes;
use Domain\Discounts\Enums\DiscountAdvantageTypes;
use Domain\Discounts\Models\Discount;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderDiscount;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\OrderItems\OrderItemDiscount;
use Domain\Orders\Models\Shipping\ShippingMethod;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Traits\BelongsTo\BelongsToDiscount;
use Support\Traits\HasModelUtilities;

/**
 * Class DiscountAdvantage
 *
 * @property int $id
 * @property int $discount_id
 * @property DiscountAdvantageTypes $advantage_type_id
 * @property float $amount
 * @property int $apply_shipping_id
 * @property int $apply_shipping_country
 * @property int $apply_shipping_distributor
 * @property ApplyQtyTypes $applyto_qty_type
 * @property int $applyto_qty_combined
 *
 * @property DiscountAdvantageTypes $discount_advantage_type
 * @property AccountAddress $accounts_addressbook
 * @property Discount $discount
 * @property Collection|array<Product> $products
 * @property AdvantageProductType $discount_advantage_producttype
 * @property Collection|array<OrderDiscount> $orders_discounts
 * @property Collection|array<OrderItemDiscount> $orders_products_discounts
 *
 * @package Domain\Orders\Models\Discount
 */
class DiscountAdvantage extends Model
{
    use HasModelUtilities, HasFactory,
        BelongsToDiscount;

    protected $table = 'discount_advantage';

    protected $casts = [
        'discount_id' => 'int',
        'advantage_type_id' => DiscountAdvantageTypes::class,
        'amount' => 'float',
        'apply_shipping_id' => 'int',
        'apply_shipping_country' => 'int',
        'apply_shipping_distributor' => 'int',
        'applyto_qty_type' => ApplyQtyTypes::class,
        'applyto_qty_combined' => 'int',
        'type' => DiscountAdvantageTypes::class,
    ];

    protected $fillable = [
        'discount_id',
        'advantage_type_id',
        'amount',
        'apply_shipping_id', //todo update to "applyto_shipping_method_id"
        'apply_shipping_country',
        'apply_shipping_distributor',
        'applyto_qty_type',
        'applyto_qty_combined',
    ];

    public function type(): DiscountAdvantageTypes
    {
        return $this->advantage_type_id;
    }

    public function applyQtyType(): ApplyQtyTypes
    {
        return $this->applyto_qty_type;
    }

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class, 'apply_shipping_id');
    }


    public function targetProducts(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            AdvantageProduct::class,
            'advantage_id',
            'product_id'
        )
            ->withPivot('applyto_qty', 'id');
    }

    public function productTypes(): HasMany
    {
        return $this->hasMany(
            AdvantageProductType::class,
            'advantage_id'
        );
    }
    public function products(): HasMany
    {
        return $this->hasMany(
            AdvantageProduct::class,
            'advantage_id'
        );
    }

    public function targetProductTypes(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductType::class,
            AdvantageProductType::class,
            'advantage_id',
            'producttype_id'
        )
            ->withPivot('applyto_qty', 'id');
    }

    public function appliedToOrders()
    {
        //todo
        return $this->hasManyThrough(
            Order::class,
            OrderDiscount::class,
            'advantage_id'
        );
    }

    public function appliedToOrderedProducts()
    {
        //todo
        return $this->hasManyThrough(
            OrderItem::class,
            OrderItemDiscount::class,
            'advantage_id'
        );
    }

    public function amountDisplay(): string
    {
        return $this->type()->amount($this->amount);
    }

    public function qtyToUse(int $combinedQty, int $individualQty): int
    {
        return $this->applyQtyType()->isCombined()
            ? $combinedQty
            : $individualQty;
    }
}
