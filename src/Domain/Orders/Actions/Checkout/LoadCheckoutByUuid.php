<?php

namespace Domain\Orders\Actions\Checkout;

use Domain\Orders\Models\Checkout\Checkout;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadCheckoutByUuid extends AbstractAction
{
    public function __construct(
        public string $uuid,
        public bool   $useCache = true,
    )
    {
    }

    public function execute(): Checkout
    {
        if (!$this->useCache) {
            return $this->load();
        }

        return Cache::tags([
            'checkout-uuid-cache.' . $this->uuid,
        ])
            ->remember(
                'load-checkout-by-uuid.' . $this->uuid,
                60 * 5,
                fn() => $this->load()
            );
    }

    public function load(): Checkout
    {
        return Checkout::where('uuid', $this->uuid)->first()
            ?? throw new ModelNotFoundException(
                __("No checkout matching UUID :uuid", [
                    'uuid' => $this->uuid,
                ])
            );
    }
}
