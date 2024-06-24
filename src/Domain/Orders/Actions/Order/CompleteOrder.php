<?php

namespace Domain\Orders\Actions\Order;


use Domain\Affiliates\Actions\CreateReferralForOrder;
use Domain\Orders\Actions\Order\Discount\CreateOrderDiscountsFromCart;
use Domain\Orders\Actions\Order\Shipment\CreateShipmentFromDto;
use Domain\Orders\Collections\OrderShipmentDtosCollection;
use Domain\Orders\Dtos\OrderShipmentDto;
use Domain\Orders\Enums\Order\OrderStatuses;
use Domain\Orders\Exceptions\OrderNotReadyForCompletionException;
use Domain\Orders\Jobs\OrderCompleted;
use Domain\Orders\Models\Order\Order;
use Domain\System\Models\System;
use Support\Contracts\AbstractAction;

class CompleteOrder extends AbstractAction
{
    private bool $isPaid = false;
    private int $defaultShipmentStatus;
    private bool $ignoreAffiliate = false;

    public function __construct(
        public Order                       $order,
        public float                       $total,
        public OrderShipmentDtosCollection $shipments,
    ) {
    }

    public function isPaid(bool $paid = true): static
    {
        $this->isPaid = $paid;

        return $this;
    }

    public function ignoreAffiliate(bool $ignore = true): static
    {
        $this->ignoreAffiliate = $ignore;

        return $this;
    }

    public function result(): Order
    {
        return $this->order;
    }

    public function execute(): static
    {
        $this->validate();

        //        $this->notifyAvailabilityChange();
        $this->defaultShipmentStatus = $this->defaultStatus();

        $this->shipments->each(
            fn (OrderShipmentDto $shipment) => CreateShipmentFromDto::run(
                $this->order,
                $shipment,
                $this->isPaid,
                $this->defaultShipmentStatus
            )
        );

        $this
            ->recordDiscounts()
            ->recordReferral();

        $this->order->update([
            'status' => OrderStatuses::Completed,
        ]);

        $this->order->activity(
            __("Completed :total", [
                'total' => \money($this->total, "USD", true)
            ])
        );
        OrderCompleted::dispatch(
            $this->order
        );

        return $this;
    }

    protected function validate(): void
    {
        OrderNotReadyForCompletionException::check($this->order);
    }

    public function recordDiscounts(): static
    {
        CreateOrderDiscountsFromCart::now(
            $this->order,
            $this->order->cartCached()
        );

        return $this;
    }

    public function recordReferral(): static
    {
        if (!$this->order->affiliate_id || $this->ignoreAffiliate) {
            return $this;
        }

        $referral = CreateReferralForOrder::now(
            $this->order,
            $this->order->affiliateCached()
        );

        $this->order->activity(
            __("Affiliate referral - :name: :amount", [
                'name' => $this->order->affiliate->name,
                'amount' => $referral->amount
            ])
        );

        return $this;
    }

    public function defaultStatus(): int
    {
        if ($this->isPaid)
            return $this->getSystem()->orderPlacedDefaultStatus()['default'];

        return $this->getSystem()->orderPlacedDefaultStatus()['unpaid'];
    }

    protected function getSystem(): System
    {
        return app(System::class);
    }
}
