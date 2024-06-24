<?php

namespace Domain\Distributors\Models\Shipping\old;

use Domain\Distributors\Models\Shipping\DistributorShippingMethod;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DistributorsShippingFlatrate
 *
 * @property int $id
 * @property int $distributor_shippingmethod_id
 * @property float $start_weight
 * @property float $end_weight
 * @property int $shipto_country
 * @property bool $status
 * @property float $flat_price
 * @property float $handling_fee
 * @property bool $call_for_estimate
 *
 * @property DistributorShippingMethod $distributors_shipping_method
 *
 * @package Domain\Distributors\Models
 */
class DistributorShippingFlatRate extends Model
{
    public $timestamps = false;
    protected $table = 'distributors_shipping_flatrates';

    protected $casts = [
        'distributor_shippingmethod_id' => 'int',
        'start_weight' => 'float',
        'end_weight' => 'float',
        'shipto_country' => 'int',
        'status' => 'bool',
        'flat_price' => 'float',
        'handling_fee' => 'float',
        'call_for_estimate' => 'bool',
    ];

    protected $fillable = [
        'distributor_shippingmethod_id',
        'start_weight',
        'end_weight',
        'shipto_country',
        'status',
        'flat_price',
        'handling_fee',
        'call_for_estimate',
    ];

    public function shippingMethod()
    {
        return $this->belongsTo(DistributorShippingMethod::class, 'distributor_shippingmethod_id');
    }
}
