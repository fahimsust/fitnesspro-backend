<?php

namespace Domain\Payments\Models;

use Domain\Accounts\Models\Membership\SubscriptionPaymentOption;
use Domain\Orders\Models\Checkout\CheckoutDetails;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\QueryBuilders\PaymentMethodQuery;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SitePaymentMethod;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Support\Traits\HasModelUtilities;

/**
 * Class PaymentMethod
 *
 * @property int $id
 * @property string $name
 * @property string $display
 * @property int $gateway_id
 * @property bool $status
 * @property string|null $template
 * @property bool $limitby_country
 * @property bool $feeby_country
 *
 * @property PaymentGateway $payment_gateway
 * @property SubscriptionPaymentOption $accounts_memberships_payment_method
 * @property Collection|array<OrderTransaction> $orders_transactions
 * @property Collection|array<PaymentMethodCountries> $payment_methods_limitcountries
 * @property Collection|array<CheckoutDetails> $saved_order_informations
 * @property Collection|array<Site> $sites
 *
 * @package Domain\Payments\Models
 */
class PaymentMethod extends Model
{
    use HasModelUtilities,
        HasFactory;

    public $timestamps = false;

    protected $table = 'payment_methods';

    protected $casts = [
        'gateway_id' => 'int',
        'status' => 'bool',
        'limitby_country' => 'bool',
        'feeby_country' => 'bool',
        'supports_auto_renewal' => 'bool',
    ];

    protected $fillable = [
        'name',
        'display',
        'gateway_id',
        'status',
        'template',
        'limitby_country',
        'feeby_country',
        'supports_auto_renewal',
    ];

    public function newEloquentBuilder($query)
    {
        return new PaymentMethodQuery($query);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleted(function (PaymentMethod $method) {
            $method->clearCaches();
        });

        static::updated(function (PaymentMethod $method) {
            $method->clearCaches();
        });
    }

    public function clearCaches(): void
    {
        Cache::tags([
            'payment-method-cache.' . $this->id,
        ])->flush();
    }

//    public static function scopeActiveMemberShip(Builder $query)
//    {
//        return $query->where(['status' => PaymentMethodStatus::ACTIVE])
//            ->whereHas(SubscriptionPaymentOption::table(), function (Builder $query) {
//                $query->where('site_id', config('site.id'));
//            });
//    }

    public function subscriptionOption(): HasMany
    {
        return $this->hasMany(SubscriptionPaymentOption::class);
    }

    public function checkoutOption()
    {
        return $this->hasMany(SitePaymentMethod::class);
    }

    public function paymentGateway()
    {
        return $this->belongsTo(PaymentGateway::class, 'gateway_id');
    }
    public function paymentAccounts()
    {
        return $this->hasMany(
            PaymentAccount::class,
            'gateway_id',
            'gateway_id',
        );
    }

    public function orderTransactions()
    {
        return $this->hasMany(OrderTransaction::class);
    }

    public function countries()
    {
        return $this->hasMany(PaymentMethodCountries::class);
    }

    public function sites()
    {
        //todo
        return $this->hasManyThrough(
            Site::class,
            SitePaymentMethod::class,
        )
            ->withPivot('gateway_account_id', 'fee');
    }
}
