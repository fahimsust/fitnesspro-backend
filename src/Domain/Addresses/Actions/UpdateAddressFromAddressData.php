<?php

namespace Domain\Addresses\Actions;

use Domain\Addresses\Models\Address;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Dtos\AddressDto;

class UpdateAddressFromAddressData
{
    use AsObject;

    public function handle(AddressDto $addressData, Address $address): Address
    {
        $address->update($addressData->toModelArray());
        return $address;
    }
}
