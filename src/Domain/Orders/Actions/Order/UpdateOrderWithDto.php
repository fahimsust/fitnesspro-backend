<?php

namespace Domain\Orders\Actions\Order;


use Domain\Orders\Dtos\OrderDto;
use Domain\Orders\Models\Order\Order;
use Support\Contracts\AbstractAction;

class UpdateOrderWithDto extends AbstractAction
{
    public function __construct(
        public Order $order,
        public OrderDto $dto
    )
    {
    }

    public function execute(): Order
    {
        $this->order->update(
            $this->dto->toModel()
        );

        return $this->order;
    }
}
