<?php

namespace Domain\Orders\Jobs;

use Domain\Orders\Actions\Order\LoadOrderById;
use Domain\Orders\Models\Order\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CompleteOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Order $order;

    public function __construct(
        public int $orderId
    )
    {
    }

    public function handle()
    {
        $this->order = LoadOrderById::now($this->orderId);

        \Domain\Orders\Actions\Order\CompleteOrder::now(
            $this->order
        );
    }
}
