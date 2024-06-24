<?php

namespace Domain\Accounts\Actions;

use App\Api\Admin\Accounts\Requests\AccountAddressRequest;
use Domain\Accounts\Models\AccountAddress;
use Lorisleiva\Actions\Concerns\AsObject;
use Illuminate\Support\Facades\Hash;

class UpdateAccountAddress
{
    use AsObject;

    public function handle(
        AccountAddressRequest $request,
        AccountAddress $accountAddress
    )
    {
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
        if( !$accountAddress->address )
        {
            throw new \Exception(__('Invalid account address'));
        }
        $accountAddress->address()->update($data);

        if( $request->is_default_address && $request->is_default_address == 1 )
        {
            // Check if the address is for billing and update the default billing ID
            if ($request->is_billing) {
                $accountAddress->account()->update([
                    "default_billing_id" => $accountAddress->id
                ]);
            }

            // Check if the address is for shipping and update the default shipping ID
            if ($request->is_shipping) {
                $accountAddress->account()->update([
                    "default_shipping_id" => $accountAddress->id
                ]);
            }

        }
        $accountAddress->update([
            'is_shipping' => $request->is_shipping,
            'is_billing' => $request->is_billing,
            'status' => $request->status
        ]);
    }
}
