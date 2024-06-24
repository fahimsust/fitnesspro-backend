<?php

namespace Domain\Affiliates\Actions;

use Domain\Affiliates\Models\Affiliate;
use Illuminate\Support\Facades\Cookie;
use Lorisleiva\Actions\Concerns\AsObject;

class CheckAffiliateCookie
{
    use AsObject;

    public function handle(): ?Affiliate
    {
        $affiliateId = Cookie::get('affiliate_referral_id');

        if (! $affiliateId) {
            return null;
        }

        Cookie::queue(
            Cookie::forget('affiliate_referral_id')
        );

        return Affiliate::find($affiliateId);
    }
}
