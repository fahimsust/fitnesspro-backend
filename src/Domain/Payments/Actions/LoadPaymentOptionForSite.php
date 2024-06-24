<?php

namespace Domain\Payments\Actions;

use Domain\Sites\Models\Site;
use Domain\Sites\Models\SitePaymentMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadPaymentOptionForSite extends AbstractAction
{
    public function __construct(
        public Site $site,
        public int  $paymentMethodId,
        public bool $useCache = true,
    )
    {
    }

    public function execute(): SitePaymentMethod
    {
        if (!$this->useCache) {
            return $this->load();
        }

        return Cache::remember(
            'load-payment-option-by-site-method.'
            . $this->site->id
            . '.' . $this->paymentMethodId,
            60 * 60,
            fn() => $this->load()
        );
    }

    public function load(): SitePaymentMethod|Model
    {
        return SitePaymentMethod::query()
            ->where('site_id', $this->site->id)
            ->where('payment_method_id', $this->paymentMethodId)
            ->first()
            ?? throw new ModelNotFoundException(
                __("No payment method matching ID :id for site :site.", [
                    'id' => $this->paymentMethodId,
                    'site' => $this->site->name,
                ])
            );
    }
}
