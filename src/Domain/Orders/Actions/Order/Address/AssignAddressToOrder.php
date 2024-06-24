<?php

namespace Domain\Orders\Actions\Order\Address;

use App\Api\Admin\Orders\Requests\CreateOrderAddressRequest;
use Domain\Orders\Actions\Order\AddOrderActivity;
use Domain\Orders\Models\Order\Order;
use Support\Contracts\AbstractAction;

class AssignAddressToOrder extends AbstractAction
{

    public function __construct(
        public Order                $order,
        public CreateOrderAddressRequest $request,
    ) {
    }

    public function execute(): void
    {
        if ($this->request->is_billing) {
            $this->order->update(['billing_address_id' => $this->request->address_id]);
            AddOrderActivity::now(
                $this->order,
                "Assigned Address - Id: " . $this->request->address_id . " to order billing address"
            );
        } else {
            $this->order->update(['shipping_address_id' => $this->request->address_id]);
            AddOrderActivity::now(
                $this->order,
                "Assigned Address - Id: " . $this->request->address_id . " to order shipping address"
            );
        }
    }
}
