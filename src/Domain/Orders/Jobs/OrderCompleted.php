<?php

namespace Domain\Orders\Jobs;

use Domain\Orders\Models\Order\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Collection;

class OrderCompleted implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Collection $processedDiscounts;

    public function __construct(public Order $order)
    {
        $this->processedDiscounts = collect();
    }

    public function handle()
    {
        foreach ($this->order->discounts as $discount) {
            if ($this->processedDiscounts->contains($discount->id)) {
                continue;
            }

            if ($discount->limit_uses == 1) {
                $discount->delete();
            }

            $this->processedDiscounts->push($discount->id);
        }
    }
}
