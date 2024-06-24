<?php

namespace Domain\Affiliates\Actions;

use App\Api\Admin\Affiliates\Requests\UpdateAffiliateRequest;
use Domain\Affiliates\Models\Affiliate;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateAffiliate
{
    use AsObject;

    public function handle(
        Affiliate              $affiliate,
        UpdateAffiliateRequest $request
    ): Affiliate
    {
        $data = [
            'email' => $request->email,
            'name' => $request->name,
            'affiliate_level_id' => $request->affiliate_level_id,
            'account_id' => $request->account_id,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $affiliate->update($data);

        return $affiliate;
    }
}
