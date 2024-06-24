<?php

namespace Domain\Accounts\Actions;

use App\Api\Admin\Accounts\Requests\AccountRequest;
use Domain\Accounts\Models\Account;
use Lorisleiva\Actions\Concerns\AsObject;
use Illuminate\Support\Facades\Hash;

class UpdateAccount
{
    use AsObject;

    public function handle(
        AccountRequest $request,
        Account $account
    )
    {
        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'status_id' => $request->status_id,
            'affiliate_id' => $request->affiliate_id,
            'photo_id' => $request->photo_id,
            'profile_public' => $request->profile_public,
            'admin_notes' => $request->admin_notes
        ];
        if( $request->password )
        {
            $data['password'] = Hash::make($request->password);
        }
        $account->update($data);
    }
}
