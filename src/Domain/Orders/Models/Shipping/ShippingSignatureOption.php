<?php

namespace Domain\Orders\Models\Shipping;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ShippingSignatureOption
 *
 * @property int $id
 * @property string $name
 * @property int $carrier_id
 * @property string $carrier_reference
 *
 * @property ShippingCarrier $shipping_carrier
 *
 * @package Domain\Orders\Models\Shipping
 */
class ShippingSignatureOption extends Model
{
    public $timestamps = false;
    protected $table = 'shipping_signature_options';

    protected $casts = [
        'carrier_id' => 'int',
    ];

    protected $fillable = [
        'name',
        'carrier_id',
        'carrier_reference',
    ];

    public function carrier()
    {
        return $this->belongsTo(ShippingCarrier::class, 'carrier_id');
    }
}
