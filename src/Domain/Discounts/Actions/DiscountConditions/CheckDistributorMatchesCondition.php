<?php

namespace Domain\Discounts\Actions\DiscountConditions;

use Domain\Discounts\Contracts\CartConditionCheck;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Symfony\Component\HttpFoundation\Response;

class CheckDistributorMatchesCondition extends CartConditionCheck
{
    public function check(): bool
    {
        return $this->cart->itemsCached()
            ->contains(
                fn(CartItem $item) => in_array(
                    $item->distributor_id,
                    $this->requiredDistributorArray()
                )
            )
            ?: $this->failed(
                __('No items in cart match required distributors for condition'),
                Response::HTTP_NOT_ACCEPTABLE
            );
    }

    private function requiredDistributorArray(): array
    {
        return $this->condition
            ->loadMissingReturn('distributors')
            ->pluck('id')
            ->toArray();
    }
}
