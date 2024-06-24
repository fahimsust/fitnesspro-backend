<?php

namespace Domain\Sites\Models;

use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\BelongsTo\BelongsToPaymentAccount;
use Support\Traits\BelongsTo\BelongsToPaymentMethod;
use Support\Traits\BelongsTo\BelongsToSite;
use Support\Traits\HasModelUtilities;

/**
 * Class SitesPaymentMethod
 *
 * @property int $site_id
 * @property int $payment_method_id
 * @property int $gateway_account_id
 * @property float|null $fee
 *
 * @property PaymentAccount $payment_gateways_account
 * @property PaymentMethod $payment_method
 * @property Site $site
 *
 * @package Domain\Sites\Models
 */
class SitePaymentMethod extends Model
{
    use HasFactory,
        HasModelUtilities,
        BelongsToSite,
        BelongsToPaymentMethod,
        BelongsToPaymentAccount;

    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'sites_payment_methods';

    protected $casts = [
        'site_id' => 'int',
        'payment_method_id' => 'int',
        'gateway_account_id' => 'int',
        'fee' => 'float',
    ];

    protected $fillable = [
        'site_id' => 'int',
        'payment_method_id' => 'int',
        'gateway_account_id' => 'int',
        'fee',
    ];

    public function scopeActive(Builder $query)
    {
        return $query->whereHas(
            'paymentMethod',
            fn ($query) => $query->active()
        );
    }

    public function scopeForSite(Builder $query, int $siteId)
    {
        return $query->where('site_id', $siteId);
    }
}
