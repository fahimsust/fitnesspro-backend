<?php

namespace Domain\Products\Actions;

use Domain\Products\Exceptions\NotAvailableToOrder;
use Domain\Products\Models\Product\ProductAvailability;
use Support\Contracts\AbstractAction;

class CheckAllowedToOrderAvailability extends AbstractAction
{
    public function __construct(
        public ProductAvailability $availability,
        public ?array              $allowedToOrderAvailabilities
    )
    {
    }

    public function execute(): bool
    {
        if (is_null($this->allowedToOrderAvailabilities)) {
            return true;
        }

        if (!in_array($this->availability->id, $this->allowedToOrderAvailabilities)) {
            throw new NotAvailableToOrder(
                __('Sorry, item is not currently available to order.')
            );
        }

        return true;
    }
}
