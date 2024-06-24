<?php

namespace Domain\Payments\Actions;

use Domain\Payments\Models\PaymentMethod;
use Domain\Products\Exceptions\ProductNotFoundException;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadPaymentMethodById extends AbstractAction
{
    public function __construct(
        public int  $methodId,
        public bool $useCache = true,
    )
    {
    }

    public function execute(): PaymentMethod
    {
        if (!$this->useCache) {
            return $this->load();
        }

        return Cache::tags([
            'payment-method-cache.' . $this->methodId,
        ])
            ->remember(
                'load-payment-method-by-id.' . $this->methodId,
                60 * 60,
                fn() => $this->load()
            );
    }

    public function load(): PaymentMethod
    {
        return PaymentMethod::find($this->methodId)
            ?? throw new ModelNotFoundException(__("No payment method matching ID {$this->methodId} for cart item."));
    }
}
