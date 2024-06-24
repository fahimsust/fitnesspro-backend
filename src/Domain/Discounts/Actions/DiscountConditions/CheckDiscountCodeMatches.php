<?php

namespace Domain\Discounts\Actions\DiscountConditions;

use Domain\Discounts\Contracts\CartConditionCheck;
use Symfony\Component\HttpFoundation\Response;

class CheckDiscountCodeMatches extends CartConditionCheck
{
    public function check(): bool
    {
        //check if already applied
        foreach ($this->cart->discountCodes as $discountCode) {
            if ($discountCode->code != $this->condition->required_code) {
                $this->failed(
                    __("Discount code already applied to cart"),
                    Response::HTTP_PRECONDITION_FAILED
                );
            }
        }

        return true;
    }
}
