<?php

namespace Domain\Accounts\Actions;

use App\Api\Admin\Accounts\Requests\CreateAccountAddressRequest;
use Domain\Accounts\Models\AccountAddress;
use Domain\Addresses\Models\Address;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateAccountAddress
{
    use AsObject;

    public function handle(
        CreateAccountAddressRequest $request,
    ) {
        $data = [
            'label' => $request->label,
            'company' => $request->company,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'city' => $request->city,
            'state_id' => $request->state_id,
            'country_id' => $request->country_id,
            'postal_code' => $request->postal_code,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_residential' => $request->is_residential
        ];
        $address = Address::create($data);
        if ($address) {
            AccountAddress::create([
                'is_shipping' => $request->is_shipping,
                'is_billing' => $request->is_billing,
                'status' => $request->status,
                'account_id' => $request->account_id,
                'address_id' => $address->id
            ]);
        } else {
            throw new \Exception(__('Something went wrong'));
        }
    }
}
