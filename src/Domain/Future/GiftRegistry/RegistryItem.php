<?php

namespace Domain\Future\GiftRegistry;

use Carbon\Carbon;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kirschbaum\PowerJoins\PowerJoins;
use Support\Traits\HasModelUtilities;

/**
 * Class GiftregistryItem
 *
 * @property int $id
 * @property int $registry_id
 * @property int $product_id
 * @property int $parent_product
 * @property Carbon $added
 * @property float $qty_wanted
 * @property float $qty_purchased
 * @property bool $status
 *
 * @property Product $product
 * @property GiftRegistry $giftregistry
 * @property ItemPurchases $giftregistry_items_purchased
 * @property Collection|array<OrderItem> $orders_products
 * @property Collection|array<CartItem> $saved_cart_items
 *
 * @package Domain\Accounts\Models\GiftCards
 */
class RegistryItem extends Model
{
    use HasModelUtilities,
        HasFactory,
        PowerJoins;
    public $timestamps = false;

    protected $table = 'giftregistry_items';

    protected $casts = [
        'registry_id' => 'int',
        'product_id' => 'int',
        'parent_product' => 'int',
        'qty_wanted' => 'float',
        'qty_purchased' => 'float',
        'status' => 'bool',
        'added' => 'datetime',
    ];

    protected $fillable = [
        'registry_id',
        'product_id',
        'parent_product',
        'added',
        'qty_wanted',
        'qty_purchased',
        'status',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function registry(): BelongsTo
    {
        return $this->belongsTo(GiftRegistry::class, 'registry_id');
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(ItemPurchases::class, 'registry_item_id');
    }

    public function inCarts(): HasMany
    {
        return $this->hasMany(CartItem::class, 'registry_item_id');
    }
}
