<?php

namespace App\Api\Admin\Orders\Controllers;

use Domain\AdminUsers\Models\AdminEmailsSent;
use Domain\Orders\Models\Order\Order;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class OrderEmailController extends AbstractController
{
    public function index(Request $request,Order $order)
    {
        return response(
            AdminEmailsSent::with([
                'sentBy',
                'sentToAccount',
            ])
                ->where('order_id', $order->id)
                ->when(
                    $request->filled('order_by'),
                    fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc'),
                    fn ($query) => $query->orderBy('sent_date', 'DESC')
                )
                ->paginate(),
            Response::HTTP_OK
        );
    }
}
