<?php

namespace Domain\Orders\Actions\Checkout;

use App\Api\Orders\Resources\Order\OrderResource;
use App\Api\Payments\Contracts\PaymentRequest;
use Domain\Orders\Enums\Order\OrderPaymentStatuses;
use Domain\Orders\Enums\Order\OrderStatuses;
use Domain\Orders\Exceptions\CheckoutAlreadyCompletedException;
use Domain\Orders\Models\Checkout\Checkout;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Support\Contracts\AbstractAction;
use Support\Dtos\RedirectUrl;
use Support\Traits\ActionExecuteReturnsStatic;
use Symfony\Component\HttpFoundation\Response;

class PlaceOrderForCheckout extends AbstractAction
{
    use ActionExecuteReturnsStatic;

    public OrderTransaction|RedirectUrl|true $paymentResult;
    private Order $order;

    public function __construct(
        public Checkout       $checkout,
        public PaymentRequest $paymentRequest,
    )
    {
    }

    public function execute(): static
    {
        CheckoutAlreadyCompletedException::check($this->checkout);

        //todo validate checkout is ready for payment

        $this->paymentResult = PayForCheckout::now(
            CreateUpdateOrderForCheckout::now($this->checkout),
            $this->checkout,
            $this->paymentRequest,
            $this->checkout->total()
        );

        if (!($this->paymentResult instanceof RedirectUrl)) {
            $this->order = CompleteOrderForCheckout::now($this->checkout);
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
                'order' => new OrderResource($this->checkout->orderCached())
            ];
        }

        return ['order' => new OrderResource($this->order)];
    }

    public function statusResponse(): int
    {
        if ($this->paymentResult instanceof RedirectUrl) {
            return Response::HTTP_ACCEPTED;
        }

        return Response::HTTP_CREATED;
    }
}
