<?php

namespace Domain\Orders\Actions\Checkout;


use App\Api\Payments\Contracts\PaymentRequest;
use Domain\Orders\Actions\Order\PayOrderUsingPaymentRequest;
use Domain\Orders\Models\Checkout\Checkout;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Actions\LoadSitePaymentAccountFromMethod;
use Domain\Payments\Models\PaymentMethod;
use Support\Contracts\AbstractAction;
use Support\Dtos\RedirectUrl;

class PayForCheckout extends AbstractAction
{
    public function __construct(
        public Order          $order,
        public Checkout       $checkout,
        public PaymentRequest $request,
        public float          $amount,
    )
    {
    }

    public function execute(): OrderTransaction|RedirectUrl|true
    {
        if ($this->amount <= 0) {
            return true;
        }

        return PayOrderUsingPaymentRequest::now(
            order: $this->order,
            request: $this->request,
            method: $this->getPaymentMethod(),
            amount: $this->amount,
            account: LoadSitePaymentAccountFromMethod::now(
                $this->checkout->siteCached(),
                $this->getPaymentMethod()
            ),
        );
    }

    protected function getPaymentMethod(): PaymentMethod
    {
        return $this->paymentMethod
            ??= $this->checkout->paymentMethodCached();
    }
}
