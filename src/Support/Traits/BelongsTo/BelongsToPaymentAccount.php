<?php

namespace Support\Traits\BelongsTo;

use Domain\Payments\Actions\LoadPaymentAccountByIdFromCache;
use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToPaymentAccount
{
    private PaymentAccount $paymentAccountCached;

    public function paymentAccount(): BelongsTo
    {
        return $this->belongsTo(PaymentAccount::class, 'gateway_account_id');
    }

    public function paymentAccountCached(): ?PaymentAccount
    {
        if(!$this->gateway_account_id) {
            return null;
        }

        return $this->paymentAccountCached
            ??= LoadPaymentAccountByIdFromCache::now($this->gateway_account_id);
    }
}
