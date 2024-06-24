<?php

namespace Domain\Distributors\Models\Shipping;

use Domain\Distributors\Models\Distributor;
use Domain\Distributors\Models\Shipping\old\DistributorShippingFlatRate;
use Domain\Orders\Models\Shipping\ShippingMethod;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Traits\BelongsTo\BelongsToDistributor;
use Support\Traits\HasModelUtilities;

/**
 * Class DistributorsShippingMethod
 *
 * @property int $id
 * @property int $distributor_id
 * @property int $shipping_method_id
 * @property bool $status
 * @property float $flat_price
 * @property bool $flat_use
 * @property float $handling_fee
 * @property float $handling_percentage
 * @property bool $call_for_estimate
 * @property float $discount_rate
 * @property string|null $display
 * @property bool|null $override_is_international
 *
 * @property Distributor $distributor
 * @property ShippingMethod $shipping_method
 * @property Collection|array<DistributorShippingFlatRate> $distributors_shipping_flatrates
 *
 * @package Domain\Distributors\Models
 */
class DistributorShippingMethod extends Model
{
    use HasModelUtilities,
        HasFactory,
        BelongsToDistributor;

    public $timestamps = false;
    protected $table = 'distributors_shipping_methods';

    protected $casts = [
        'distributor_id' => 'int',
        'shipping_method_id' => 'int',
        'status' => 'bool',
        'flat_price' => 'float',
        'flat_use' => 'bool',
        'handling_fee' => 'float',
        'handling_percentage' => 'float',
        'call_for_estimate' => 'bool',
        'discount_rate' => 'float',
        'override_is_international' => 'bool',
    ];

    protected $fillable = [
        'distributor_id',
        'shipping_method_id',
        'status',
        'flat_price',
        'flat_use',
        'handling_fee',
        'handling_percentage',
        'call_for_estimate',
        'discount_rate',
        'display',
        'override_is_international',
    ];

    public function shippingMethod(): BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function flatRates(): HasMany
    {
        return $this->hasMany(DistributorShippingFlatRate::class, 'distributor_shippingmethod_id');
    }
}
