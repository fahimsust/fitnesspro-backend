<?php

namespace App\Api\Orders\Controllers\Checkout;

use App\Api\Orders\Requests\Checkout\SetCheckoutPaymentMethodRequest;
use Domain\Orders\Actions\Checkout\SetCheckoutPaymentMethod;
use Support\Controllers\AbstractController;

class PaymentMethodController extends AbstractController
{
    public function __invoke(
        SetCheckoutPaymentMethodRequest $request,
    )
    {
        return [
            'method' => SetCheckoutPaymentMethod::now(
                $request->loadCheckoutByUuid(),
                $request->payment_method_id,
            )->paymentMethodCached()
        ];
    }
}
