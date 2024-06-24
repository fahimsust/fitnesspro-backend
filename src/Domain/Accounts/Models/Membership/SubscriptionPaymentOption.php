<?php

namespace Domain\Accounts\Models\Membership;

use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\BelongsTo\BelongsToPaymentAccount;
use Support\Traits\BelongsTo\BelongsToPaymentMethod;
use Support\Traits\BelongsTo\BelongsToSite;
use Support\Traits\HasModelUtilities;

class SubscriptionPaymentOption extends Model
{
    use HasModelUtilities,
        HasFactory,
        BelongsToSite,
        BelongsToPaymentMethod,
        BelongsToPaymentAccount;

    protected $table = 'membership_payment_methods';

    protected $casts = [
        'site_id' => 'int',
        'payment_method_id' => 'int',
        'gateway_account_id' => 'int',
    ];

    protected $fillable = [
        'site_id',
        'payment_method_id',
        'gateway_account_id',
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
        return $query->where(['site_id' => $siteId]);
    }
}
