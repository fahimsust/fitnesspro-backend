<?php

namespace App\Api\Orders\Controllers\Checkout;

use App\Api\Orders\Requests\Checkout\CompleteCheckoutRequest;
use App\Api\Orders\Resources\Order\OrderResource;
use App\Api\Payments\Contracts\PaymentRequest;
use Domain\Orders\Actions\Checkout\CompleteOrderForCheckout;
use Domain\Orders\Actions\Checkout\LoadCheckoutByUuid;
use Domain\Orders\Actions\Checkout\PlaceOrderForCheckout;
use Support\Controllers\AbstractController;

class PayCompleteController extends AbstractController
{
    public function store(string $checkoutId, PaymentRequest $request)
    {
        $checkout = PlaceOrderForCheckout::now(
            LoadCheckoutByUuid::now($checkoutId),
            $request
        );

        return response(
            $checkout->jsonResponse(),
            $checkout->statusResponse()
        );
    }

    public function update(CompleteCheckoutRequest $request)
    {
        return [
            'order' => new OrderResource(
                CompleteOrderForCheckout::now(
                    $request->loadCheckoutByUuid()
                )
            )
        ];
    }
}
