<?php

namespace Domain\Orders\Exceptions;

use Domain\Orders\Models\Order\Order;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class OrderNotReadyForCompletionException
    extends Exception implements HttpExceptionInterface
{
    public function __construct(
        $message = '',
        $code = null,
        ?Throwable $previous = null
    )
    {
        parent::__construct(__('Order not ready to complete: :error', ['error' => $message]), $this->getStatusCode(), $previous);
    }

    public static function check(Order $order): void
    {
        if (!$order->hasCart()) {
            throw new static(__('Cart is required'));
        }

        if (!$order->hasBillingAddress()) {
            throw new static(__('Billing address is required'));
        }

        if (!$order->hasShippingAddress()) {
            throw new static(__('Shipping address is required'));
        }

        if (!$order->status->readyToComplete()) {
            throw new static(__('Status is :status', [
                'status' => $order->status->name,
            ]));
        }
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_PRECONDITION_FAILED;
    }

    public function getHeaders(): array
    {
        return [];
    }
}
