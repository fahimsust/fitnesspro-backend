<?php

namespace App\Api\Orders\Controllers\Checkout;

use App\Api\Orders\Requests\Checkout\SetCheckoutAccountRequest;
use App\Api\Orders\Resources\Checkout\CheckoutResource;
use Domain\Orders\Actions\Checkout\SetAccountForCheckout;
use Support\Controllers\AbstractController;

class AccountController extends AbstractController
{
    public function __invoke(SetCheckoutAccountRequest $request)
    {
        return [
            'checkout' => new CheckoutResource(
                SetAccountForCheckout::now(
                    $request->loadCheckoutByUuid(),
                    $request->account_id
                )
            )
        ];
    }
}
