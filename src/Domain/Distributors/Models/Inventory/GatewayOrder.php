<?php

namespace Domain\Distributors\Models\Inventory;

use Carbon\Carbon;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InventoryGatewaysOrder
 *
 * @property int $id
 * @property int $gateway_account_id
 * @property string $gateway_order_id
 * @property int $shipment_id
 * @property float $total_amount
 * @property Carbon $created
 * @property Carbon $modified
 * @property bool $status
 *
 * @property InventoryAccount $inventory_gateways_account
 * @property Shipment $orders_shipment
 *
 * @package Domain\Distributors\Models\Inventory
 */
class GatewayOrder extends Model
{
    public $timestamps = false;
    protected $table = 'inventory_gateways_orders';

    protected $casts = [
        'gateway_account_id' => 'int',
        'shipment_id' => 'int',
        'total_amount' => 'float',
        'status' => 'bool',
        'created' => 'datetime',
        'modified' => 'datetime',
    ];

    protected $fillable = [
        'gateway_account_id',
        'gateway_order_id',
        'shipment_id',
        'total_amount',
        'created',
        'modified',
        'status',
    ];

    public function inventoryAccount()
    {
        return $this->belongsTo(
            InventoryAccount::class,
            'gateway_account_id'
        );
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id');
    }
}
