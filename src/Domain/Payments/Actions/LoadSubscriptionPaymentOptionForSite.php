<?php

namespace Domain\Payments\Actions;

use Domain\Accounts\Models\Membership\SubscriptionPaymentOption;
use Domain\Payments\Models\PaymentMethod;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadSubscriptionPaymentOptionForSite extends AbstractAction
{
    public function __construct(
        public Site          $site,
        public PaymentMethod $paymentMethod,
        public bool          $useCache = true,
    )
    {
    }

    public function execute(): SubscriptionPaymentOption
    {
        if (!$this->useCache) {
            return $this->load();
        }

        return Cache::remember(
            'load-subscription-payment-option-by-site-method.'
            . $this->site->id
            . '.' . $this->paymentMethod->id,
            60 * 60,
            fn() => $this->load()
        );
    }

    public function load(): SubscriptionPaymentOption
    {
        return SubscriptionPaymentOption::query()
            ->forSite($this->site->id)
            ->where('payment_method_id', $this->paymentMethod->id)
            ->first()
            ?? throw new ModelNotFoundException(
                __("No payment method matching ID {$this->paymentMethod->id} for site {$this->site->name}.")
            );
    }
}
