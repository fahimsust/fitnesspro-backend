<?php

namespace Domain\Orders\Actions\Order;


use Support\Contracts\AbstractAction;

class GenerateOrderNumber extends AbstractAction
{
    public function execute(): string
    {
        return now()->timestamp . '-' . mt_rand(100, 999);
    }
}
