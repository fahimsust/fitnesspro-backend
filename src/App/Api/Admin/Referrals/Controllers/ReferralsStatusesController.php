<?php

namespace App\Api\Admin\Referrals\Controllers;

use Domain\Affiliates\Models\ReferralStatus;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ReferralsStatusesController extends AbstractController
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return response(
            ReferralStatus::all(),
            Response::HTTP_OK
        );
    }
}
