<?php

namespace Domain\Orders\Actions\Order\Discount;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Support\Contracts\AbstractAction;

class IsOrderAdvantage extends AbstractAction
{

    public function __construct(
        public DiscountAdvantage $advantage,
    )
    {
    }

    public function execute(): bool
    {
        return $this->advantage->type()->isOrderAdvantage();
    }
}
