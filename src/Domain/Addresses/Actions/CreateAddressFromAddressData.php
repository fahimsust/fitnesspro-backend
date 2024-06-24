<?php

namespace Domain\Addresses\Actions;

use Domain\Addresses\Models\Address;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Dtos\AddressDto;

class CreateAddressFromAddressData
{
    use AsObject;

    public function handle(AddressDto $addressData): Address
    {
        return Address::create($addressData->toModelArray());
    }
}
