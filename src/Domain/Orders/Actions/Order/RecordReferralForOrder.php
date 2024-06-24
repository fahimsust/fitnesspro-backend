<?php

namespace Domain\Orders\Actions\Order;

use Domain\Orders\Models\Order\Order;
use Support\Contracts\AbstractAction;

class RecordReferralForOrder extends AbstractAction
{
    public function __construct(
        public Order $order,
    )
    {
    }

    public function execute()
    {
    }
}
