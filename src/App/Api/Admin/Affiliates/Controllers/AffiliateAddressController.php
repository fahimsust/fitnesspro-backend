<?php

namespace App\Api\Admin\Affiliates\Controllers;

use App\Api\Admin\Affiliates\Requests\AffiliateAddressRequest;
use Domain\Affiliates\Models\Affiliate;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AffiliateAddressController extends AbstractController
{
    public function __invoke(Affiliate $affiliate, AffiliateAddressRequest $request)
    {
        return response(
            $affiliate->update(['address_id' => $request->address_id]),
            Response::HTTP_OK
        );
    }
}
