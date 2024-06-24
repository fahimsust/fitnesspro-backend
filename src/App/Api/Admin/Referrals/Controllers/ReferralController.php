<?php

namespace App\Api\Admin\Referrals\Controllers;

use App\Api\Admin\Referrals\Requests\ReferralSearchRequest;
use App\Api\Admin\Referrals\Requests\ReferralStatusRequest;
use Domain\Affiliates\Actions\ChangeReferralStatus;
use Domain\Affiliates\Models\Referral;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ReferralController extends AbstractController
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ReferralSearchRequest $request)
    {
        return response(
            Referral::search($request)
                ->when(
                    $request->filled('order_by') && $request->order_by != "order_no" && $request->order_by != "name",
                    fn($query) => $query->orderBy($request->order_by, $request->order_type ? $request->order_type : 'asc')
                )
                ->with([
                    'order' => function ($query) use ($request) {
                        if ($request->filled('order_by') && $request->order_by == "order_no")
                            $query->orderBy($request->order_by, $request->order_type ? $request->order_type : 'asc');
                    },
                    'status',
                    'affiliate' => function ($query) use ($request) {
                        if ($request->filled('order_by') && $request->order_by == "name")
                            $query->orderBy($request->order_by, $request->order_type ? $request->order_type : 'asc');
                    },
                ])
                ->paginate(),
            Response::HTTP_OK
        );
    }
    public function update(Referral $referral, ReferralStatusRequest $request)
    {
        return response(
            ChangeReferralStatus::run($referral, $request),
            Response::HTTP_CREATED
        );
    }
}
