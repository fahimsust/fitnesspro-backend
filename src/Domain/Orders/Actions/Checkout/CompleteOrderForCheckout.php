<?php

namespace Domain\Orders\Actions\Checkout;

use Domain\Accounts\Jobs\Membership\SendSiteMailable;
use Domain\Orders\Actions\Order\CompleteOrder;
use Domain\Orders\Collections\OrderShipmentDtosCollection;
use Domain\Orders\Enums\Checkout\CheckoutStatuses;
use Domain\Orders\Enums\Order\OrderPaymentStatuses;
use Domain\Orders\Exceptions\CheckoutAlreadyCompletedException;
use Domain\Orders\Mail\OrderPlaced;
use Domain\Orders\Models\Checkout\Checkout;
use Domain\Orders\Models\Order\Order;
use Support\Contracts\AbstractAction;

class CompleteOrderForCheckout extends AbstractAction
{
    private Order $order;

    public function __construct(
        public Checkout $checkout,
    )
    {
        $this->order = $this->checkout->orderCached();
    }

    public function execute(): Order
    {
        CheckoutAlreadyCompletedException::check($this->checkout);

        $this->order->update([
            'cart_id' => $this->checkout->cart_id,
            'site_id' => $this->checkout->site_id,
            'account_id' => $this->checkout->account_id,
            'affiliate_id' => $this->checkout->affiliate_id,
            'billing_address_id' => $this->checkout->billing_address_id,
            'shipping_address_id' => $this->checkout->shipping_address_id,
            'payment_method' => $this->checkout->payment_method_id,
            'comments' => $this->checkout->comments,
        ]);

        $totalAmount = $this->checkout->cartCached()->total();

        $this->order = (new CompleteOrder(
            $this->order,
            $totalAmount,
            OrderShipmentDtosCollection::fromCheckoutModel(
                $this->checkout
                    ->loadMissing(
                        'shipments',
                        'shipments.packages',
                        'shipments.packages.items',
                        'shipments.packages.items.discounts',
                    )
            )
        ))
            ->isPaid($this->order->payment_status == OrderPaymentStatuses::Paid)
            ->execute()
            ->result();

        SendSiteMailable::dispatch(
            $this->checkout->siteCached(),
            (new OrderPlaced($this->checkout->accountCached()))
                ->order($this->order)
        );

        $this->checkout->update([
            'status' => CheckoutStatuses::Completed
        ]);

        return $this->order;
    }
}
