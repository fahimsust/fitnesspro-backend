<?php

namespace Domain\Accounts\Actions\Registration\Order;

use Domain\Accounts\Actions\Membership\CreateMembershipFromRegistration;
use Domain\Accounts\Jobs\Membership\SendSiteMailable;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Affiliates\Jobs\CreateAffiliateFromAccount;
use Domain\Orders\Actions\Order\CompleteOrder;
use Domain\Orders\Collections\OrderShipmentDtosCollection;
use Domain\Orders\Dtos\OrderItemDto;
use Domain\Orders\Dtos\OrderPackageDto;
use Domain\Orders\Dtos\OrderShipmentDto;
use Domain\Orders\Enums\Order\OrderPaymentStatuses;
use Domain\Orders\Mail\OrderPlaced;
use Domain\Orders\Models\Order\Order;
use Support\Contracts\AbstractAction;

class CompleteOrderForRegistration extends AbstractAction
{
    private Order $order;
    private OrderItemDto $itemDto;

    public function __construct(
        public Registration $registration,
    )
    {
        $this->order = $this->registration->orderCached();
    }

    public function execute(): Order
    {
        $totalAmount = $this->registration->cartCached()->total();

        $this->order = (new CompleteOrder(
            $this->order,
            $totalAmount,
            new OrderShipmentDtosCollection(
                [
                    OrderShipmentDto::withPackage(
                        OrderPackageDto::withItem($this->getOrderItemDto()),
                        $this->getOrderItemDto()->distributor->id,
                        $this->getOrderItemDto()->product->isDigital()
                    )->order($this->order)
                ]
            )
        ))
            ->isPaid($this->order->payment_status == OrderPaymentStatuses::Paid)
            ->execute()
            ->result();

        CreateMembershipFromRegistration::now(
            $this->registration,
            $totalAmount,
            $this->registration->levelWithProductPricingCached()
                ->product
                ->pricingBySiteCached($this->registration->siteCached())
                ->price()
        );

        CreateAffiliateFromAccount::dispatch(
            $this->registration->accountCached()
        );

        SendSiteMailable::dispatch(
            $this->registration->siteCached(),
            (new OrderPlaced($this->registration->accountCached()))
                ->order($this->order)
        );

        return $this->order;
    }

    protected function getOrderItemDto(): OrderItemDto
    {
        return $this->itemDto ??= OrderItemDto::fromCartItem(
            $this->registration
                ->cartCached()
                ->itemsCached()
                ->first(),
        );
    }
}
