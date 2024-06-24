<?php

namespace Domain\Orders\Models\Order\Transactions;

use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class OrdersTransactionsBilling
 *
 * @property int $orders_transactions_id
 * @property string $bill_first_name
 * @property string $bill_last_name
 * @property string $bill_address_1
 * @property string $bill_address_2
 * @property string $bill_city
 * @property int $bill_state_id
 * @property string $bill_postal_code
 * @property int $bill_country_id
 * @property string $bill_phone
 *
 * @property Country $country
 * @property StateProvince $state
 * @property OrderTransaction $orders_transaction
 *
 * @package Domain\Orders\Models
 */
class OrderTransactionBillingAddress extends Model
{
    use HasModelUtilities;
    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'orders_transactions_billing';
    protected $primaryKey = 'orders_transactions_id';

    protected $casts = [
        'orders_transactions_id' => 'int',
        'bill_state_id' => 'int',
        'bill_country_id' => 'int',
    ];

    protected $fillable = [
        'bill_first_name',
        'bill_last_name',
        'bill_address_1',
        'bill_address_2',
        'bill_city',
        'bill_state_id',
        'bill_postal_code',
        'bill_country_id',
        'bill_phone',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'bill_country_id');
    }

    public function state()
    {
        return $this->belongsTo(StateProvince::class, 'bill_state_id');
    }

    public function transaction()
    {
        return $this->belongsTo(OrderTransaction::class, 'orders_transactions_id');
    }
}
