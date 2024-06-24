<?php

namespace App\Api\Orders\Requests\Cart;

use App\Api\Orders\Traits\ConfirmsCartOwner;
use Domain\Orders\Enums\Cart\CartItemRelations;
use Worksome\RequestFactories\Concerns\HasFactory;

class RemoveItemFromCartRequest extends AbstractCartItemRequest
{
    use HasFactory,
        ConfirmsCartOwner;

    protected function itemRelations(): array
    {
        return [
            CartItemRelations::DISCOUNT_ADVANTAGES,
            CartItemRelations::DISCOUNT_CONDITIONS,
        ];
    }
}
