<?php

namespace Domain\Orders\Actions\Order;


use App\Api\Payments\Contracts\PaymentRequest;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Dtos\PaymentRequestData;
use Domain\Payments\Enums\PaymentMethodActions;
use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use Support\Contracts\AbstractAction;
use Support\Dtos\RedirectUrl;

class PayOrderUsingPaymentRequest extends AbstractAction
{
    public OrderTransaction $transaction;

    public function __construct(
        public Order          $order,
        public PaymentRequest $request,
        public PaymentMethod  $method,
        public float          $amount,
        public ?PaymentAccount $account,
    )
    {
    }

    public function execute(): OrderTransaction|RedirectUrl|true
    {
        $result = PaymentMethodActions::from(
            $this->method->id
        )
            ->initiatePaymentRequest(
                new PaymentRequestData(
                    order: $this->order,
                    request: $this->request,
                    method: $this->method,
                    amount: $this->amount,
                    account: $this->account,
                )
            );

        return $result;
    }
}
