<?php

namespace Domain\Payments\Models;

use Domain\Locales\Models\Country;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentGatewaysAccountsLimitcountry
 *
 * @property int $id
 * @property int $gateway_account_id
 * @property int $country_id
 *
 * @property Country $country
 * @property PaymentAccount $payment_gateways_account
 *
 * @package Domain\Payments\Models
 */
class PaymentAccountCountry extends Model
{
    public $timestamps = false;
    protected $table = 'payment_gateways_accounts_limitcountries';

    protected $casts = [
        'gateway_account_id' => 'int',
        'country_id' => 'int',
    ];

    protected $fillable = [
        'gateway_account_id',
        'country_id',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function paymentAccount()
    {
        return $this->belongsTo(PaymentAccount::class, 'gateway_account_id');
    }
}
