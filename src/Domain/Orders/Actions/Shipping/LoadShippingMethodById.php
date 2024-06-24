<?php

namespace Domain\Orders\Actions\Shipping;

use Domain\Orders\Models\Shipping\ShippingMethod;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadShippingMethodById extends AbstractAction
{
    public function __construct(
        public int  $methodId,
        public bool $useCache = true,
    )
    {
    }

    public function execute(): ShippingMethod
    {
        if (!$this->useCache) {
            return $this->load();
        }

        return Cache::tags([
            'shipping-method-cache.' . $this->methodId,
        ])
            ->remember(
                'load-shipping-method-by-id.' . $this->methodId,
                60 * 5,
                fn() => $this->load()
            );
    }

    public function load(): ShippingMethod
    {
        return ShippingMethod::find($this->methodId)
            ?? throw new ModelNotFoundException(
                __("No shipping method matching ID :id.", [
                    'id' => $this->methodId,
                ])
            );
    }
}
