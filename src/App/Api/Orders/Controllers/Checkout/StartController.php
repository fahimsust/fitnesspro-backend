<?php

namespace App\Api\Orders\Controllers\Checkout;

use App\Api\Orders\Requests\Checkout\SetCheckoutAccountRequest;
use App\Api\Orders\Requests\Checkout\StartCheckoutRequest;
use App\Api\Orders\Resources\Checkout\CheckoutResource;
use Domain\Orders\Actions\Cart\LoadCartById;
use Domain\Orders\Actions\Checkout\FindCreateCheckout;
use Domain\Orders\Actions\Checkout\SetAccountForCheckout;
use Support\Controllers\AbstractController;

class StartController extends AbstractController
{
    public function __invoke(StartCheckoutRequest $request)
    {
        return [
            'checkout' => new CheckoutResource(
                FindCreateCheckout::now(
                    $request->cart,
                    $request->account,
                )
            )
        ];
    }
}
