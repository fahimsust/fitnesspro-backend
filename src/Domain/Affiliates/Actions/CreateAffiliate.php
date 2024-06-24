<?php

namespace Domain\Affiliates\Actions;

use App\Api\Admin\Affiliates\Requests\CreateAffiliateRequest;
use Domain\Affiliates\Models\Affiliate;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateAffiliate
{
    use AsObject;

    public function handle(
        CreateAffiliateRequest $request
    ): Affiliate {
        return Affiliate::create(
            [
                'email' => $request->email,
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'affiliate_level_id' => $request->affiliate_level_id,
                'account_id' => $request->account_id,
            ]
        );
    }
}
