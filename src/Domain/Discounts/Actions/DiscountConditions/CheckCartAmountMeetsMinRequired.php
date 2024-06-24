<?php

namespace Domain\Discounts\Actions\DiscountConditions;

use Domain\Discounts\Contracts\CartConditionCheck;
use Symfony\Component\HttpFoundation\Response;

class CheckCartAmountMeetsMinRequired extends CartConditionCheck
{
    public function check(): bool
    {
        if (!$this->cart) {
            return false;
        }

        if ($this->cart->subTotal() >= $this->condition->required_cart_value) {
            return true;
        }

        $this->failed(
            __('Cart amount :amount less than :required', [
                'amount' => $this->cart->subTotal(),
                'required' => $this->condition->required_cart_value,
            ]),
            Response::HTTP_NOT_ACCEPTABLE
        );
    }
}
