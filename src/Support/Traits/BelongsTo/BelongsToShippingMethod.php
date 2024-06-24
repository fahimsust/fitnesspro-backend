<?php

namespace Support\Traits\BelongsTo;

use Domain\Orders\Actions\Shipping\LoadShippingMethodById;
use Domain\Orders\Models\Shipping\ShippingMethod;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToShippingMethod
{
    private ShippingMethod $shippingMethodCached;

    public function shippingMethod(): BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function shippingMethodCached(): ?ShippingMethod
    {
        if (!$this->shipping_method_id) {
            return null;
        }

        if (
            $this->relationLoaded('shippingMethod')
            && $this->shippingMethod
        ) {
            return $this->shippingMethod;
        }

        $this->shippingMethodCached ??= LoadShippingMethodById::now(
            $this->shipping_method_id
        );

        $this->setRelation('shippingMethod', $this->shippingMethodCached);

        return $this->shippingMethodCached;
    }
}
