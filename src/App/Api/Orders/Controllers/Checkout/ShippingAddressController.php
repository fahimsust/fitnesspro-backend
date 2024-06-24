<?php

namespace App\Api\Orders\Controllers\Checkout;

use App\Api\Orders\Requests\Checkout\SetCheckoutShippingAddressRequest;
use Domain\Orders\Actions\Checkout\SetCheckoutShippingAddress;
use Support\Controllers\AbstractController;

class ShippingAddressController extends AbstractController
{
    public function __invoke(
        SetCheckoutShippingAddressRequest $request,
    )
    {
        return [
            'address' => SetCheckoutShippingAddress::now(
                $request->loadCheckoutByUuid(),
                $request->address_id,
                setAsBilling: $request->set_as_billing
            )->shippingAddressCached()
        ];
    }
}
