<?php

namespace App\Api\Orders\Resources\Checkout;

use Domain\Accounts\Models\Account;
use Domain\Affiliates\Models\Affiliate;
use Illuminate\Http\Resources\Json\JsonResource;

class AffiliateResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Affiliate $affiliate */
        $affiliate = $this->resource;

        return [
            'id' => $affiliate->id,
        ];
    }
}
