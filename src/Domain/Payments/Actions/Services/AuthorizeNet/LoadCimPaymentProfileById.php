<?php

namespace Domain\Payments\Actions\Services\AuthorizeNet;

use Domain\Accounts\Models\Cim\CimPaymentProfile;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadCimPaymentProfileById extends AbstractAction
{
    public function __construct(
        protected int  $paymentProfileId,
        protected bool $useCache = true,
    )
    {
    }

    public function execute()
    {
        if (!$this->useCache) {
            return $this->load();
        }

        return Cache::tags([
            'cim-payment-profile-cache.' . $this->paymentProfileId,
        ])
            ->remember(
                'load-cim-payment-profile-by-id.' . $this->paymentProfileId,
                60 * 60 * 24,
                fn() => $this->load()
            );
    }

    protected function load(): CimPaymentProfile
    {
        return CimPaymentProfile::find($this->paymentProfileId);
    }
}
