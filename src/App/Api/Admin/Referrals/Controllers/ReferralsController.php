<?php

namespace App\Api\Admin\Referrals\Controllers;

use App\Api\Admin\Referrals\Requests\ReferralSearchRequest;
use Domain\Affiliates\Models\Referral;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ReferralsController extends AbstractController
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($affiliate_id, ReferralSearchRequest $request)
    {
        return response(
            Referral::whereAffiliateId($affiliate_id)
                ->search($request)
                ->when(
                    $request->filled('order_by') && $request->order_by != "order_no",
                    fn($query) => $query->orderBy($request->order_by, $request->order_type ? $request->order_type : 'asc')
                )
                ->with([
                    'order' => function ($query) use ($request) {
                        if ($request->filled('order_by') && $request->order_by == "order_no")
                            $query->orderBy($request->order_by, $request->order_type ? $request->order_type : 'asc');
                    },
                    'status'
                ])
                ->paginate(),
            Response::HTTP_OK
        );
    }
}
