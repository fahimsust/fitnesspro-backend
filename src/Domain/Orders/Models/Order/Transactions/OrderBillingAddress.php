<?php

namespace Domain\Orders\Models\Order\Transactions;

use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Domain\Orders\Models\Order\Order;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class OrdersBilling
 *
 * @property int $order_id
 * @property string $bill_company
 * @property string $bill_first_name
 * @property string $bill_last_name
 * @property string $bill_address_1
 * @property string $bill_address_2
 * @property string $bill_city
 * @property int $bill_state_id
 * @property int $bill_country_id
 * @property string $bill_postal_code
 * @property string $bill_phone
 * @property string $bill_email
 *
 * @property Country $country
 * @property StateProvince $state
 * @property Order $order
 *
 * @package Domain\Orders\Models
 */
class OrderBillingAddress extends Model
{
    use HasModelUtilities;
    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'orders_billing';
    protected $primaryKey = 'order_id';

    protected $casts = [
        'order_id' => 'int',
        'bill_state_id' => 'int',
        'bill_country_id' => 'int',
    ];

    protected $fillable = [
        'bill_company',
        'bill_first_name',
        'bill_last_name',
        'bill_address_1',
        'bill_address_2',
        'bill_city',
        'bill_state_id',
        'bill_country_id',
        'bill_postal_code',
        'bill_phone',
        'bill_email',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'bill_country_id');
    }

    public function state()
    {
        return $this->belongsTo(StateProvince::class, 'bill_state_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
