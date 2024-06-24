<?php

namespace Domain\Orders\Models\Order\Shipments;

use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Domain\Orders\Models\Order\Order;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class OrdersShipping
 *
 * @property int $order_id
 * @property string $ship_company
 * @property string $ship_first_name
 * @property string $ship_last_name
 * @property string $ship_address_1
 * @property string $ship_address_2
 * @property string $ship_city
 * @property int $ship_state_id
 * @property int $ship_country_id
 * @property string $ship_postal_code
 * @property string $ship_email
 * @property string $ship_phone
 * @property bool $is_residential
 *
 * @property Order $order
 * @property Country $country
 * @property StateProvince $state
 *
 * @package Domain\Orders\Models
 */
class OrderShippingAddress extends Model
{
    use HasModelUtilities;
    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'orders_shipping';
    protected $primaryKey = 'order_id';

    protected $casts = [
        'order_id' => 'int',
        'ship_state_id' => 'int',
        'ship_country_id' => 'int',
        'is_residential' => 'bool',
    ];

    protected $fillable = [
        'ship_company',
        'ship_first_name',
        'ship_last_name',
        'ship_address_1',
        'ship_address_2',
        'ship_city',
        'ship_state_id',
        'ship_country_id',
        'ship_postal_code',
        'ship_email',
        'ship_phone',
        'is_residential',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'ship_country_id');
    }

    public function state()
    {
        return $this->belongsTo(StateProvince::class, 'ship_state_id');
    }
}
