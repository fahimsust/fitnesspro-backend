<?php

namespace Domain\Orders\Models\Shipping;

use Domain\Locales\Models\Country;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ShippingCarriersShipto
 *
 * @property int $id
 * @property int $shipping_carriers_id
 * @property int $country_id
 *
 * @property Country $country
 * @property ShippingCarrier $shipping_carrier
 *
 * @package Domain\Orders\Models\Shipping
 */
class CarrierShipToCountries extends Model
{
    public $timestamps = false;
    protected $table = 'shipping_carriers_shipto';

    protected $casts = [
        'shipping_carriers_id' => 'int',
        'country_id' => 'int',
    ];

    protected $fillable = [
        'shipping_carriers_id',
        'country_id',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function carrier()
    {
        return $this->belongsTo(ShippingCarrier::class, 'shipping_carriers_id');
    }
}
