<?php

namespace Support\Traits\BelongsTo;

use Domain\Orders\Actions\Order\LoadOrderById;
use Domain\Orders\Models\Order\Order;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToOrder
{
    private Order $orderCached;

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function orderCached(): ?Order
    {
        if (!$this->order_id) {
            return null;
        }

        if ($this->relationLoaded('order')) {
            return $this->order;
        }

        $this->orderCached ??= LoadOrderById::now($this->order_id);

        $this->setRelation('order', $this->orderCached);

        return $this->orderCached;
    }
}
