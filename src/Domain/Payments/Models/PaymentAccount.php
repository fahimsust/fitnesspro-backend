<?php

namespace Domain\Payments\Models;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Cim\CimProfile;
use Domain\Locales\Models\Country;
use Domain\Payments\QueryBuilders\PaymentAccountQuery;
use Domain\Payments\Services\PaypalCheckout\DataObjects\AccessToken;
use Domain\Payments\Services\PaypalCheckout\Enums\PaypalModes;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SitePaymentMethod;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Support\Traits\ClearsCache;
use Support\Traits\HasModelUtilities;

/**
 * Class PaymentGatewaysAccount
 *
 * @property int $id
 * @property int $gateway_id
 * @property string $name
 * @property string $login_id
 * @property string $password
 * @property string $transaction_key
 * @property bool $use_cvv
 * @property string $currency_code
 * @property bool $use_test
 * @property string $custom_fields
 * @property bool $limitby_country
 *
 * @property PaymentGateway $payment_gateway
 * @property Collection|array<CimProfile> $cim_profiles
 * @property Collection|array<PaymentAccountCountry> $payment_gateways_accounts_limitcountries
 * @property PaymentAccountError $payment_gateways_error
 * @property Collection|array<SitePaymentMethod> $sites_payment_methods
 *
 * @package Domain\Payments\Models
 */
class PaymentAccount extends Model
{
    use HasModelUtilities,
        HasFactory,
        ClearsCache;

    protected $table = 'payment_gateways_accounts';

    protected $casts = [
        'gateway_id' => 'int',
        'use_cvv' => 'bool',
        'use_test' => 'bool',
        'limitby_country' => 'bool',
        'credentials' => 'array',
    ];

    protected $hidden = [
        'password',
        'credentials',
    ];

    protected $fillable = [
        'gateway_id',
        'name',
        'login_id',
        'password',
        'transaction_key',
        'use_cvv',
        'currency_code',
        'use_test',
        'custom_fields',
        'limitby_country',
        'credentials'
    ];

    protected function cacheTags(): array
    {
        return [
            'payment-account-cache.' . $this->id,
        ];
    }

    public function newEloquentBuilder($query)
    {
        return new PaymentAccountQuery($query);
    }

    public function credentials(string $key, mixed $value = null)
    {
        if (is_null($value)) {
            return $this->credentials[$key] ?? null;
        }

        $this->update(['credentials->'.$key => $value]);
    }

    public function gateway(): BelongsTo
    {
        return $this->belongsTo(PaymentGateway::class);
    }

    public function countries()
    {
        //todo
        return $this->hasManyThrough(
            Country::class,
            PaymentAccountCountry::class,
            'gateway_account_id'
        );
    }

    public function errors()
    {
        return $this->hasMany(
            PaymentAccountError::class,
            'gateway_account_id'
        );
    }

    public function sites()
    {
        return $this->hasManyThrough(
            Site::class,
            SitePaymentMethod::class,
            'gateway_account_id'
        );
    }
}
