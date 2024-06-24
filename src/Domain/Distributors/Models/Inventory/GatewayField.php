<?php

namespace Domain\Distributors\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

/**
 * Class InventoryGatewaysField
 *
 * @property int $id
 * @property int $gateway_id
 * @property string $feed_field
 * @property string $product_field
 * @property bool $displayorvalue
 *
 * @property InventoryGateway $payment_gateway
 *
 * @package Domain\Distributors\Models\Inventory
 */
class GatewayField extends Model
{
    public $timestamps = false;
    protected $table = 'inventory_gateways_fields';

    protected $casts = [
        'gateway_id' => 'int',
        'displayorvalue' => 'bool',
    ];

    protected $fillable = [
        'gateway_id',
        'feed_field',
        'product_field',
        'displayorvalue',
    ];

    public function inventoryGateway()
    {
        return $this->belongsTo(InventoryGateway::class, 'gateway_id');
    }
}
