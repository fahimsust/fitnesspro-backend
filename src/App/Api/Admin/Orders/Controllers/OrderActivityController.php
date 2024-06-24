<?php

namespace App\Api\Admin\Orders\Controllers;

use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderActivity;
use Support\Controllers\AbstractController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderActivityController extends AbstractController
{
    public function index(Request $request,Order $order)
    {
        return response(
            OrderActivity::whereOrderId($order->id)
                ->with('adminUser')
                ->when(
                    $request->filled('order_by'),
                    fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc'),
                    fn ($query) => $query->orderBy('created', 'DESC')
                )
                ->paginate(),
            Response::HTTP_OK
        );
    }
}
