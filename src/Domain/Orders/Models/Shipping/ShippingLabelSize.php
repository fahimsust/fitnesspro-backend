<?php

namespace Domain\Orders\Models\Shipping;

use Domain\Orders\Models\Order\Shipments\ShipmentLabel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ShippingLabelSize
 *
 * @property int $id
 * @property string $name
 * @property int $gateway_id
 * @property string $carrier_code
 * @property bool $default
 * @property bool $status
 * @property int $label_template
 *
 * @property ShippingGateway $shipping_gateway
 * @property Collection|array<ShipmentLabel> $orders_shipments_labels
 *
 * @package Domain\Orders\Models\Shipping
 */
class ShippingLabelSize extends Model
{
    public $timestamps = false;
    protected $table = 'shipping_label_sizes';

    protected $casts = [
        'gateway_id' => 'int',
        'default' => 'bool',
        'status' => 'bool',
        'label_template' => 'int',
    ];

    protected $fillable = [
        'name',
        'gateway_id',
        'carrier_code',
        'default',
        'status',
        'label_template',
    ];

    public function gateway()
    {
        return $this->belongsTo(ShippingGateway::class, 'gateway_id');
    }

    public function labels()
    {
        return $this->hasMany(ShipmentLabel::class, 'label_size_id');
    }
}
