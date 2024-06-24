<?php

namespace App\Api\Admin\Orders\Controllers;

use App\Api\Admin\Orders\Requests\AssignAffiliateRequest;
use Domain\Affiliates\Actions\CreateReferralForOrder;
use Domain\Affiliates\Models\Affiliate;
use Domain\Affiliates\Models\Referral;
use Domain\Orders\Models\Order\Order;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class OrderReferralController extends AbstractController
{
    public function index(Order $order, Request $request)
    {
        return response(
            Referral::whereOrderId($order->id)
                ->with(['affiliate','status','order'])
                ->orderBy('id', 'desc')
                ->when(
                    $request->filled('order_by'),
                    fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc'),
                    fn ($query) => $query->orderBy('created', 'DESC')
                )
                ->paginate(),
            Response::HTTP_OK
        );
    }
    public function store(Order $order, AssignAffiliateRequest $request)
    {
        return response(
            CreateReferralForOrder::now($order, Affiliate::find($request->affiliate_id)),
            Response::HTTP_CREATED
        );
    }
    public function destroy(Order $order, Referral $affiliate)
    {
        return response(
            $affiliate->delete(),
            Response::HTTP_CREATED
        );
    }
}
