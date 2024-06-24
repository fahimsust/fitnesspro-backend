<?php

namespace Domain\Distributors\Models\Shipping;

use Domain\Addresses\Models\Address;
use Domain\Addresses\Traits\BelongsToAddress;
use Domain\Distributors\Models\Distributor;
use Domain\Orders\Models\Shipping\ShippingGateway;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\BelongsTo\BelongsToDistributor;
use Support\Traits\HasModelUtilities;

/**
 * Class DistributorsShippingGateway
 *
 * @property int $id
 * @property int $distributor_id
 * @property int $shipping_gateway_id
// * @property array $credentials
 * @property array $config
 * @property int $address_id
 *
 * @property Distributor $distributor
 * @property ShippingGateway $shipping_gateway
 * @property Address $address
 *
 * @package Domain\Distributors\Models
 */
class DistributorShippingGateway extends Model
{
    use HasModelUtilities,
        HasFactory,
        BelongsToAddress,
        BelongsToDistributor;

    protected $table = 'distributors_shipping_gateways';

    protected $casts = [
        'distributor_id' => 'int',
        'shipping_gateway_id' => 'int',
        'credentials' => 'array',
        'config' => 'array',
        'address_id' => 'int',
    ];

    protected $fillable = [
        'distributor_id',
        'shipping_gateway_id',
        'credentials',
        'config',
        'address_id',
    ];

    protected $hidden = [
        'credentials'
    ];

    public function gateway(): BelongsTo
    {
        return $this->belongsTo(ShippingGateway::class);
    }

    public function getConfig(string $key)
    {
        return \Arr::get($this->config, str_replace("->", ".", $key)) ?? null;
    }

    public function setConfig(string $key, mixed $value): static
    {
        $this->update(['config->'.$key => $value]);

        return $this;
    }

    public function getCredential(string $key): mixed
    {
        return \Arr::get($this->credentials, str_replace("->", ".", $key)) ?? null;
    }

    public function setCredential(string $key, mixed $value): static
    {
        $this->update(['credentials->'.$key => $value]);

        return $this;
    }
}
