<?php

namespace Domain\Future\GiftRegistry;

use Domain\Accounts\Models\Account;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class GiftregistryItemsPurchased
 *
 * @property int $registry_item_id
 * @property int $account_id
 * @property float $qty_purchased
 * @property int $order_id
 * @property int $order_product_id
 *
 * @property Account $account
 * @property Order $order
 * @property OrderItem $orders_product
 * @property RegistryItem $giftregistry_item
 *
 * @package Domain\Accounts\Models\GiftCards
 */
class ItemPurchases extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'giftregistry_items_purchased';

    protected $casts = [
        'registry_item_id' => 'int',
        'account_id' => 'int',
        'qty_purchased' => 'float',
        'order_id' => 'int',
        'order_product_id' => 'int',
    ];

    protected $fillable = [
        'registry_item_id',
        'account_id',
        'qty_purchased',
        'order_id',
        'order_product_id',
    ];

    public function purchaser(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    //TODO remove order_id and get order thru order_product_id
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function orderProduct(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class, 'order_product_id');
    }

    public function registryItem(): BelongsTo
    {
        return $this->belongsTo(RegistryItem::class, 'registry_item_id');
    }
}
