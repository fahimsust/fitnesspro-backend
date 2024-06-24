<?php

namespace Domain\Affiliates\Actions;

use App\Api\Admin\Referrals\Requests\ReferralStatusRequest;
use Domain\Affiliates\Models\Referral;
use Lorisleiva\Actions\Concerns\AsObject;

class ChangeReferralStatus
{
    use AsObject;

    public function handle(
        Referral              $referral,
        ReferralStatusRequest $request
    ): Referral
    {
        $referral->update([
            'status_id' => $request->status_id,
        ]);

        return $referral;
    }
}
