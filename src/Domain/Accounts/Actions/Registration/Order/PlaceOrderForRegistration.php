<?php

namespace Domain\Accounts\Actions\Registration\Order;

use App\Api\Payments\Contracts\PaymentRequest;
use App\Api\Payments\Contracts\PaymentRequestContract;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Support\Contracts\AbstractAction;
use Support\Dtos\RedirectUrl;
use Support\Traits\ActionExecuteReturnsStatic;
use Symfony\Component\HttpFoundation\Response;

class PlaceOrderForRegistration extends AbstractAction
{
    use ActionExecuteReturnsStatic;

    public OrderTransaction|RedirectUrl|true $paymentResult;
    private Order $order;

    public function __construct(
        public Registration   $registration,
        public PaymentRequest $paymentRequest,
    ) {
    }

    public function execute(): static
    {
        $this->paymentResult = CreateOrderAndPayForRegistration::now(
            $this->registration,
            $this->paymentRequest
        );

        if (!($this->paymentResult instanceof RedirectUrl)) {
            $this->order = CompleteOrderForRegistration::now($this->registration);
        }

        return $this;
    }

    public function result(): static
    {
        return $this;
    }

    public function jsonResponse(): array
    {
        if ($this->paymentResult instanceof RedirectUrl) {
            return [
                'jump_to' => $this->paymentResult->url,
                'order' => $this->registration->orderCached()
            ];
        }

        return ['order' => $this->order];
    }

    public function statusResponse(): int
    {
        if ($this->paymentResult instanceof RedirectUrl) {
            return Response::HTTP_ACCEPTED;
        }

        return Response::HTTP_CREATED;
    }
}
