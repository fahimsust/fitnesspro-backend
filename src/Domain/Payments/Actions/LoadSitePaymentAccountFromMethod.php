<?php

namespace Domain\Payments\Actions;


use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use Domain\Sites\Models\Site;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadSitePaymentAccountFromMethod extends AbstractAction
{
    public function __construct(
        public Site          $site,
        public PaymentMethod $paymentMethod,
        public bool          $useCache = true,
    )
    {
    }

    public function execute(): ?PaymentAccount
    {
        if (!$this->useCache) {
            return $this->load();
        }

        return Cache::remember(
            'load-payment-account-by-site-method.'
            . $this->site->id
            . '.' . $this->paymentMethod->id,
            60 * 60,
            fn() => $this->load()
        );
    }

    public function load(): ?PaymentAccount
    {
        return LoadPaymentOptionForSite::now(
            site: $this->site,
            paymentMethodId: $this->paymentMethod->id,
            useCache: $this->useCache,
        )
            ->paymentAccountCached();
    }
}
