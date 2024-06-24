<?php

namespace Domain\Products\Actions\OrderingRules;

use Domain\Accounts\Models\Account;
use Domain\Orders\Models\Carts\Cart;
use Domain\Products\Contracts\OrderingConditionCheck;
use Domain\Products\Models\OrderingRules\OrderingCondition;
use Domain\Sites\Models\Site;
use Lorisleiva\Actions\Concerns\AsObject;

class CheckOrderingCondition
{
    use AsObject;

    private OrderingConditionCheck $action;

    public function __construct(
        public OrderingCondition $condition,
        public ?Cart $cart = null,
        public ?Account $account = null,
        public ?Site $site = null,
    ) {
    }

    public function handle(): bool
    {
        $this->setAction()
            ->setAccount()
            ->setCart()
            ->setSite();

        return $this->action->check();
    }

    private function setAction(): static
    {
        $this->action = resolve($this->condition->type->action(), [
            'condition' => $this->condition,
        ]);

        return $this;
    }

    private function setCart(): static
    {
        if (is_null($this->cart) || ! method_exists($this->action, 'cart')) {
            return $this;
        }

        $this->action->cart($this->cart);

        return $this;
    }

    private function setAccount(): static
    {
        if (is_null($this->account) || ! method_exists($this->action, 'account')) {
            return $this;
        }

        $this->action->account($this->account);

        return $this;
    }

    private function setSite(): static
    {
        if (is_null($this->site) || ! method_exists($this->action, 'site')) {
            return $this;
        }

        $this->action->site($this->site);

        return $this;
    }
}
