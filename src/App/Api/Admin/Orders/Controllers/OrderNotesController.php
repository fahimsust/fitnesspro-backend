<?php

namespace App\Api\Admin\Orders\Controllers;

use App\Api\Admin\Orders\Requests\CreateOrderNoteRequest;
use Carbon\Carbon;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderNote;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;


class OrderNotesController extends AbstractController
{
    public function index(Order $order, Request $request)
    {
        return response(
            OrderNote::whereOrderId($order->id)
                ->with('user')
                ->basicKeywordSearch($request->keyword)
                ->when(
                    $request->filled('order_by'),
                    fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc'),
                    fn ($query) => $query->orderBy('created', 'DESC')
                )
                ->paginate(),
            Response::HTTP_OK
        );
    }
    public function store(Order $order, CreateOrderNoteRequest $request)
    {
        return response(
            $order->notes()->create([
                'note' => $request->note,
                "created" => Carbon::now(),
                "user_id" => auth()->user()->id
            ]),
            Response::HTTP_CREATED
        );
    }
}
