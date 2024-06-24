<?php

namespace Domain\Orders\Actions\Cart;

use Domain\Accounts\Models\Account;
use Domain\Orders\Dtos\CartDto;
use Domain\Orders\Enums\Cart\CartStatuses;
use Domain\Orders\Models\Carts\Cart;
use Domain\Sites\Models\Site;
use Support\Contracts\AbstractAction;

class StartCart extends AbstractAction
{
    public function __construct(
        public ?Site    $site = null,
        public ?Account $account = null
    )
    {
    }

    public function execute(): Cart
    {
        return (new CartDto(
            site: $this->site ?? \site(),
            status: CartStatuses::ACTIVE,
            account: $this->account,
        ))
            ->toModel();
    }
}
