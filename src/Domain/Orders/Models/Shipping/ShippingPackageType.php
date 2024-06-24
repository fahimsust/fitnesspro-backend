<?php

namespace Domain\Orders\Models\Shipping;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ShippingPackageType
 *
 * @property int $id
 * @property string $name
 * @property int $carrier_id
 * @property string $carrier_reference
 * @property bool $default
 * @property int $is_international
 *
 * @property ShippingCarrier $shipping_carrier
 *
 * @package Domain\Orders\Models\Shipping
 */
class ShippingPackageType extends Model
{
    public $timestamps = false;
    protected $table = 'shipping_package_types';

    protected $casts = [
        'carrier_id' => 'int',
        'default' => 'bool',
        'is_international' => 'int',
    ];

    protected $fillable = [
        'name',
        'carrier_id',
        'carrier_reference',
        'default',
        'is_international',
    ];

    public function carrier()
    {
        return $this->belongsTo(ShippingCarrier::class, 'carrier_id');
    }
}
