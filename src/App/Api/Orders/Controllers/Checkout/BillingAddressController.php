<?php

namespace App\Api\Orders\Controllers\Checkout;

use App\Api\Orders\Requests\Checkout\SetCheckoutBillingAddressRequest;
use Domain\Orders\Actions\Checkout\SetCheckoutBillingAddress;
use Support\Controllers\AbstractController;

class BillingAddressController extends AbstractController
{
    public function __invoke(
        SetCheckoutBillingAddressRequest $request
    )
    {
        return [
            'address' => SetCheckoutBillingAddress::now(
                $request->loadCheckoutByUuid(),
                $request->address_id,
            )->billingAddressCached()
        ];
    }
}
