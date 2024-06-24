<?php

namespace Domain\Payments\Actions;

use Domain\Accounts\Exceptions\AccountNotFoundException;
use Domain\Accounts\Models\Account;
use Domain\Payments\Models\PaymentAccount;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadPaymentAccountByIdFromCache extends AbstractAction
{
    public function __construct(
        public int $paymentAccountId,
    )
    {
    }

    public function execute(): PaymentAccount
    {
        return Cache::tags([
            "payment-account-cache.{$this->paymentAccountId}",
        ])
            ->remember(
                'load-payment-account-by-id.' . $this->paymentAccountId,
                60 * 5,
                fn() => PaymentAccount::find($this->paymentAccountId)
                    ?? throw new ModelNotFoundException(
                        __("No payment account matching ID :id.", [
                            'id' => $this->paymentAccountId,
                        ])
                    )
            );
    }
}
