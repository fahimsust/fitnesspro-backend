<?php

namespace App\Api\Orders\Requests\Cart;

use App\Api\Orders\Traits\ConfirmsCartOwner;
use Domain\Orders\Enums\Cart\CartItemRelations;
use Worksome\RequestFactories\Concerns\HasFactory;

class UpdateCartItemQtyRequest extends AbstractCartItemRequest
{
    use HasFactory,
        ConfirmsCartOwner;

    public function rules()
    {
        return array_merge([
            'qty' => ['required', 'int', 'min:1'],
        ], parent::rules());
    }

    protected function itemSelect(): array
    {
        return ['*'];
    }

    protected function itemRelations(): array
    {
        return [
            CartItemRelations::PRODUCT,
            CartItemRelations::REGISTRY_ITEM,
        ];
    }
}
