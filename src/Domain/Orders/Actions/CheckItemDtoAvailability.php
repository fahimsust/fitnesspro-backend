<?php

namespace Domain\Orders\Actions;

use Domain\Accounts\Models\Account;
use Domain\Orders\Dtos\AccessoryData;
use Domain\Orders\Dtos\CartItemDto;
use Domain\Orders\Dtos\OrderItemDto;
use Domain\Products\Actions\CheckAllowedToOrderAvailability;
use Domain\Products\Actions\OrderingRules\CheckProductAgainstOrderingRule;
use Domain\Products\Actions\Product\CheckProductIsPublishedToSite;
use Domain\Products\Models\Product\ProductAccessory;
use Domain\Sites\Models\Site;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;

class CheckItemDtoAvailability extends AbstractAction
{

    public function __construct(
        public Site $site,
        public CartItemDto|OrderItemDto $itemDto,
        public ?Account $account = null,
    )
    {
    }

    public function execute(): void
    {
        CheckProductIsPublishedToSite::run(
            $this->site,
            $this->itemDto->product,
            $this->itemDto->pricing
        );

        CheckAllowedToOrderAvailability::run(
            $this->itemDto->availability,
            $this->site->settings->allowedToOrderAvailabilities()
        );

        CheckProductAgainstOrderingRule::run(
            $this->site,
            $this->itemDto->product,
            $this->account
        );
    }
}
