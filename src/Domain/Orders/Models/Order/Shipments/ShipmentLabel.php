<?php

namespace Domain\Orders\Models\Order\Shipments;

use Domain\Orders\Models\Shipping\ShippingLabelSize;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrdersShipmentsLabel
 *
 * @property int $id
 * @property int $shipment_id
 * @property int $package_id
 * @property string $filename
 * @property int $label_size_id
 * @property string $gateway_label_id
 * @property string $tracking_no
 *
 * @property ShippingLabelSize $shipping_label_size
 * @property OrderPackage $orders_package
 * @property Shipment $orders_shipment
 *
 * @package Domain\Orders\Models
 */
class ShipmentLabel extends Model
{
    public $timestamps = false;
    protected $table = 'orders_shipments_labels';

    protected $casts = [
        'shipment_id' => 'int',
        'package_id' => 'int',
        'label_size_id' => 'int',
    ];

    protected $fillable = [
        'shipment_id',
        'package_id',
        'filename',
        'label_size_id',
        'gateway_label_id',
        'tracking_no',
    ];

    public function labelSize()
    {
        return $this->belongsTo(ShippingLabelSize::class, 'label_size_id');
    }

    public function package()
    {
        return $this->belongsTo(OrderPackage::class, 'package_id');
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id');
    }
}
