<?php

namespace App\Api\Addresses\Controllers;

use App\Api\Addresses\Requests\AddressRequest;
use Domain\Addresses\Actions\UpdateAddressFromAddressData;
use Domain\Addresses\Models\Address;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class UpdateAddressController extends AbstractController
{
    public function update(Address $accountAddress, AddressRequest $request)
    {
        return response(
            UpdateAddressFromAddressData::run($request->getData(), $accountAddress),
            Response::HTTP_CREATED
        );
    }
}
