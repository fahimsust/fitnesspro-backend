<?php

namespace Domain\Orders\Collections;

use Domain\Orders\Dtos\CheckoutItemDto;
use Domain\Orders\Models\Checkout\CheckoutItem;
use Domain\Orders\Models\Checkout\CheckoutPackage;
use Illuminate\Support\Collection;

class CheckoutItemDtosCollection extends Collection
{
    public function offsetGet($key): CheckoutItemDto
    {
        return parent::offsetGet($key);
    }

    public static function fromCheckoutPackageModel(CheckoutPackage $model): static
    {
        return new static(
            items: $model->items->map(
                fn(CheckoutItem $item) => CheckoutItemDto::fromCheckoutItem($item)
            )
        );
    }
}
