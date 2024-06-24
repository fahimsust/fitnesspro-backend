<?php

namespace Domain\Orders\Actions\Order;

use Domain\Orders\Actions\Order\AddOrderActivity;
use Domain\Orders\Models\Order\Order;
use Support\Contracts\AbstractAction;

class UpdateOrder extends AbstractAction
{

    public function __construct(
        public Order    $order,
        public $data
    ) {
    }

    public function execute(): void
    {
        $this->order->update((array)$this->data);

        $updated = [];

        if (isset($this->data->addtl_fee)) {
            $updated[] = "additional fees changed to " . $this->data->addtl_fee;
        }
        if (isset($this->data->addtl_discount)) {
            $updated[] = "additional discount changed to " . $this->data->addtl_discount;
        }

        $description = "Order updated: " .
            implode('\n - ', $updated);

        AddOrderActivity::now($this->order, $description);
    }
}
