<?php

namespace App\Api\Orders\Resources\Checkout;

use Domain\Accounts\Models\Account;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Account $account */
        $account = $this->resource;

        return [
            'id' => $account->id,
            'email' => $account->email,
            'first_name' => $account->first_name,
            'last_name' => $account->last_name,
            'phone' => $account->phone,
        ];
    }
}
