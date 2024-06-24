<?php

namespace Domain\Orders\Models\Checkout;

use Domain\Accounts\Models\AccountAddress;
use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Shipping\ShippingMethod;
use Domain\Payments\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SavedOrderInformation
 *
 * @property int $order_id
 * @property string $order_email
 * @property int $account_billing_id
 * @property int $account_shipping_id
 * @property string $bill_first_name
 * @property string $bill_last_name
 * @property string $bill_address_1
 * @property string $bill_address_2
 * @property string $bill_city
 * @property int $bill_state_id
 * @property string $bill_postal_code
 * @property int $bill_country_id
 * @property string $bill_phone
 * @property bool $is_residential
 * @property string $ship_company
 * @property string $ship_first_name
 * @property string $ship_last_name
 * @property string $ship_address_1
 * @property string $ship_address_2
 * @property string $ship_city
 * @property int $ship_state_id
 * @property string $ship_postal_code
 * @property int $ship_country_id
 * @property string $ship_email
 * @property int $payment_method_id
 * @property int $shipping_method_id
 * @property int $step
 *
 * @property AccountAddress $accounts_addressbook
 * @property Country $country
 * @property StateProvince $state
 * @property Order $order
 * @property PaymentMethod $payment_method
 *
 * @package Domain\Orders\Models\SavedOrders
 */
class CheckoutDetails extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'saved_order_information';
    protected $primaryKey = 'order_id';

    protected $casts = [
        'order_id' => 'int',
        'account_billing_id' => 'int',
        'account_shipping_id' => 'int',
        'bill_state_id' => 'int',
        'bill_country_id' => 'int',
        'is_residential' => 'bool',
        'ship_state_id' => 'int',
        'ship_country_id' => 'int',
        'payment_method_id' => 'int',
        'shipping_method_id' => 'int',
        'step' => 'int',
    ];

    protected $fillable = [
        'order_email',
        'account_billing_id',
        'account_shipping_id',
        'bill_first_name',
        'bill_last_name',
        'bill_address_1',
        'bill_address_2',
        'bill_city',
        'bill_state_id',
        'bill_postal_code',
        'bill_country_id',
        'bill_phone',
        'is_residential',
        'ship_company',
        'ship_first_name',
        'ship_last_name',
        'ship_address_1',
        'ship_address_2',
        'ship_city',
        'ship_state_id',
        'ship_postal_code',
        'ship_country_id',
        'ship_email',
        'payment_method_id',
        'shipping_method_id',
        'step',
    ];

    public function shippingAddress()
    {
        return $this->belongsTo(
            AccountAddress::class,
            'account_shipping_id'
        );
    }

    public function billingAddress()
    {
        return $this->belongsTo(
            AccountAddress::class,
            'account_billing_id'
        );
    }

    public function shipToCountry()
    {
        return $this->belongsTo(
            Country::class,
            'ship_country_id'
        );
    }

    public function shipToState()
    {
        return $this->belongsTo(
            StateProvince::class,
            'ship_state_id'
        );
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(
            PaymentMethod::class,
            'payment_method_id'
        );
    }

    public function shippingMethod()
    {
        return $this->belongsTo(
            ShippingMethod::class,
            'shipping_method_id'
        );
    }
}
