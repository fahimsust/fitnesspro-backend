<?php

namespace Domain\Discounts\Actions\DiscountConditions;

use Domain\Discounts\Contracts\CartConditionCheck;
use Domain\Orders\Actions\Cart\Item\Options\LoadCartItemOptionsFromCart;
use Domain\Orders\Models\Carts\CartItems\CartItemOption;
use Domain\Products\Enums\ProductOptionTypes;

class CheckDateRangeCondition extends CartConditionCheck
{
    public function check(): bool
    {
        if (!$this->cart) {
            return false;
        }

        return LoadCartItemOptionsFromCart::now($this->cart)
            ->contains(
                $this->checkCartItemOption(...)
            );
    }

    protected function checkCartItemOption(CartItemOption $cartOption): bool
    {
        if (
            $cartOption->option->type_id !== ProductOptionTypes::DateRange
            || !$cartOption->optionValue
        ) {
            return false;
        }

        if($this->condition->start_date){
            if(
                $cartOption->optionValue->start_date < $this->condition->start_date
                || $cartOption->optionValue->end_date < $this->condition->start_date
            ){
                return false;
            }
        }

        if($this->condition->end_date){
            if(
                $cartOption->optionValue->start_date > $this->condition->end_date
                || $cartOption->optionValue->end_date > $this->condition->end_date
            ){
                return false;
            }
        }

        return true;
    }
}
