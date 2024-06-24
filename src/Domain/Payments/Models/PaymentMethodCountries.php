<?php

namespace Domain\Payments\Models;

use Domain\Locales\Models\Country;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentMethodsLimitcountry
 *
 * @property int $id
 * @property int $payment_method_id
 * @property int $country_id
 * @property float|null $fee
 * @property bool $limiting
 *
 * @property Country $country
 * @property PaymentMethod $payment_method
 *
 * @package Domain\Payments\Models
 */
class PaymentMethodCountries extends Model
{
    public $timestamps = false;
    protected $table = 'payment_methods_limitcountries';

    protected $casts = [
        'payment_method_id' => 'int',
        'country_id' => 'int',
        'fee' => 'float',
        'limiting' => 'bool',
    ];

    protected $fillable = [
        'payment_method_id',
        'country_id',
        'fee',
        'limiting',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
