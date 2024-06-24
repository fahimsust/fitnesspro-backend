<?php

namespace Domain\Orders\Actions\Order;

use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Support\Contracts\AbstractAction;

class AddOrderActivity extends AbstractAction
{

    public function __construct(
        public Order  $order,
        public string $description
    )
    {
    }

    public function execute(): OrderActivity|Model
    {
        return $this->order->activities()
            ->create([
                'user_id' => Auth::guard('admin')->user()->id,
                'description' => $this->description,
                'created' => now()
            ]);
    }
}
