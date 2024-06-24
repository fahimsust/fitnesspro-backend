<?php

namespace App\Api\Orders\Controllers\Checkout;

use App\Api\Orders\Requests\Checkout\GetCheckoutRequest;
use App\Api\Orders\Requests\Checkout\RecoverCheckoutRequest;
use App\Api\Orders\Resources\Checkout\CheckoutResource;
use Support\Controllers\AbstractController;

class RecoveryController extends AbstractController
{
    public function show(GetCheckoutRequest $request)
    {
        return [
            'checkout' => new CheckoutResource(
                $request->loadCheckoutByUuid()
            )
        ];
    }

    public function store(RecoverCheckoutRequest $request)
    {
        //todo recover checkout

//        return [
//            'checkout' => new CheckoutResource(
//                $request->loadCheckoutByUuid()
//            )
//        ];
    }
}
