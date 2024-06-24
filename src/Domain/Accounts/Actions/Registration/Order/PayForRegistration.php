<?php

namespace Domain\Accounts\Actions\Registration\Order;


use App\Api\Payments\Contracts\PaymentRequest;
use Domain\Accounts\Enums\RegistrationRelations;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Orders\Actions\Order\PayOrderUsingPaymentRequest;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Actions\LoadSiteSubscriptionPaymentAccountFromMethod;
use Domain\Payments\Models\PaymentMethod;
use Support\Contracts\AbstractAction;
use Support\Dtos\RedirectUrl;

class PayForRegistration extends AbstractAction
{
    public function __construct(
        public Order          $order,
        public Registration   $registration,
        public PaymentRequest $request,
        public float          $amount,
    )
    {
    }

    public function execute(): OrderTransaction|RedirectUrl|true
    {
        return PayOrderUsingPaymentRequest::now(
            order: $this->order,
            request: $this->request,
            method: $this->getPaymentMethod(),
            amount: $this->amount,
            account: LoadSiteSubscriptionPaymentAccountFromMethod::now(
                $this->registration->loadMissingReturn(RegistrationRelations::Site->value),
                $this->getPaymentMethod()
            ),
        );
    }

    protected function getPaymentMethod(): PaymentMethod
    {
        return $this->paymentMethod ??= $this->registration->paymentMethodCached();
    }
}
