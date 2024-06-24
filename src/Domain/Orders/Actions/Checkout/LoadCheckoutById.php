<?php

namespace Domain\Orders\Actions\Checkout;

use Domain\Orders\Models\Checkout\Checkout;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadCheckoutById extends AbstractAction
{
    public function __construct(
        public int  $checkoutId,
        public bool $useCache = true,
    )
    {
    }

    public function execute(): Checkout
    {
        if (!$this->useCache) {
            return $this->load();
        }

        return Cache::tags([
            'checkout-cache.' . $this->checkoutId,
        ])
            ->remember(
                'load-checkout-by-id.' . $this->checkoutId,
                60 * 5,
                fn() => $this->load()
            );
    }

    public function load(): Checkout
    {
        return Checkout::find($this->checkoutId)
            ?? throw new ModelNotFoundException(__("No checkout matching ID {$this->checkoutId}."));
    }
}
