<?php

namespace Domain\Orders\Models\Shipping;

use Domain\Distributors\Models\Distributor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class ShippingGateway
 *
 * @property int $id
 * @property string $name
 * @property string $classname
 * @property string $table
 * @property bool $status
 * @property bool $multipackage_support
 *
 * @property Collection|array<Distributor> $distributors
 * @property Collection|array<ShippingCarrier> $shipping_carriers
 * @property Collection|array<ShippingLabelSize> $shipping_label_sizes
 *
 * @package Domain\Orders\Models\Shipping
 */
class ShippingGateway extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;

    protected $casts = [
        'status' => 'bool',
        'multipackage_support' => 'bool',
    ];

    protected $fillable = [
        'name',
        'classname',
        'table',
        'status',
        'multipackage_support',
    ];

    public function distributors()
    {
        //todo
        return $this->belongsToMany(
            Distributor::class,
            'distributors_shipping_gateways'
        )
            ->withPivot('id');
    }

    public function carriers()
    {
        return $this->hasMany(ShippingCarrier::class, 'gateway_id');
    }

    public function labelSizes()
    {
        return $this->hasMany(ShippingLabelSize::class, 'gateway_id');
    }
}
