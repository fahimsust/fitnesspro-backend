<?php

namespace Domain\Orders\Models\Shipping;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class ShippingCarrier
 *
 * @property int $id
 * @property int $gateway_id
 * @property string $name
 * @property string $classname
 * @property string $table
 * @property bool $status
 * @property bool $multipackage_support
 * @property string $carrier_code
 * @property bool $limit_shipto
 *
 * @property ShippingGateway $shipping_gateway
 * @property Collection|array<CarrierShipToCountries> $shipping_carriers_shiptos
 * @property Collection|array<ShippingMethod> $shipping_methods
 * @property Collection|array<ShippingPackageType> $shipping_package_types
 * @property Collection|array<ShippingSignatureOption> $shipping_signature_options
 *
 * @package Domain\Orders\Models\Shipping
 */
class ShippingCarrier extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;

    protected $table = 'shipping_carriers';

    protected $casts = [
        'gateway_id' => 'int',
        'status' => 'bool',
        'multipackage_support' => 'bool',
        'limit_shipto' => 'bool',
    ];

    protected $fillable = [
        'gateway_id',
        'name',
        'classname',
        'table',
        'status',
        'multipackage_support',
        'carrier_code',
        'limit_shipto',
    ];

    public function shippingGateway()
    {
        return $this->belongsTo(ShippingGateway::class, 'gateway_id');
    }

    public function shipToCountries()
    {
        return $this->hasMany(CarrierShipToCountries::class, 'shipping_carriers_id');
    }

    public function shippingMethods()
    {
        return $this->hasMany(ShippingMethod::class, 'carrier_id');
    }

    public function packageTypes()
    {
        return $this->hasMany(ShippingPackageType::class, 'carrier_id');
    }

    public function signatureOptions()
    {
        return $this->hasMany(ShippingSignatureOption::class, 'carrier_id');
    }
}
