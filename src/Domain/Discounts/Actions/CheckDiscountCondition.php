<?php

namespace Domain\Discounts\Actions;

use Domain\Accounts\Models\Account;
use Domain\Discounts\Contracts\DiscountConditionCheck;
use Domain\Discounts\Dtos\DiscountCheckerData;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Orders\Models\Carts\Cart;
use Support\Contracts\AbstractAction;

class CheckDiscountCondition extends AbstractAction
{
    private DiscountConditionCheck $checkerAction;

    public function __construct(
        public DiscountCheckerData $checkerData,
        public DiscountCondition $condition,
        public Cart              $cart,
        public ?Account          $account = null,
    )
    {
    }

    public function execute(): bool
    {
        $this->setAction()
            ->setAccount()
            ->setCart()
            ->setSite();

        return $this->checkerAction->check();
    }

    private function setAction(): static
    {
        $this->checkerAction = resolve(
            $this->condition->type->action(),
            [
                'checkerData' => $this->checkerData,
                'condition' => $this->condition,
            ]
        );

        return $this;
    }

    private function setCart(): static
    {
        if (is_null($this->cart) || !method_exists($this->checkerAction, 'cart')) {
            return $this;
        }

        $this->checkerAction->cart($this->cart);

        return $this;
    }

    private function setAccount(): static
    {
        if (is_null($this->account) || !method_exists($this->checkerAction, 'account')) {
            return $this;
        }

        $this->checkerAction->account($this->account);

        return $this;
    }

    private function setSite(): static
    {
        if (!method_exists($this->checkerAction, 'site')) {
            return $this;
        }

        $this->checkerAction->site($this->cart->site);

        return $this;
    }
}
