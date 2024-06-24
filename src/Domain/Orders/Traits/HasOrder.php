<?php

namespace Domain\Orders\Traits;


use Domain\Orders\Models\Order\Order;

trait HasOrder
{
    public ?Order $order = null;

    public function order(Order $order): static
    {
        $this->order = $order;

        return $this;
    }
}
