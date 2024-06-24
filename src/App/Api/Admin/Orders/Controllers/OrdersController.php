<?php

namespace App\Api\Admin\Orders\Controllers;

use App\Api\Admin\Orders\Requests\UpdateOrderRequest;
use Domain\Accounts\Models\Account;
use Domain\Orders\Actions\Order\UpdateOrder;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\QueryBuilders\OrderQuery;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class OrdersController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            Order::query()
                ->search($request)
                ->where('archived', false)
                ->when(
                    $request->filled('order_by'),
                    function ($query) use ($request) {
                        if (in_array($request->order_by, ['first_name'])) {
                            $query->orderBy(
                                Account::select($request->order_by)
                                    ->whereColumn('accounts.id', 'orders.account_id'),
                                $request->order_type ?? 'asc'
                            );

                        } else {
                            $query->orderBy($request->order_by, $request->order_type ?? 'asc');
                        };

                    }
                )
                ->with([
                    'shipments',
                    'shipments.status',
                    'shipments.items',
                    'shipments.items.optionValues',
                    'shipments.items.optionValues.optionValue',
                    'shipments.items.optionValues.optionValue.option',
                    'shipments.items.product' => function ($query) {
                        $query->withTrashed();
                    },
                    'shipments.distributor',
                    'notes',
                    'affiliate',
                    'account',
                    'billingAddress',
                    'shippingAddress'
                    ]
                )
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }

    public function show(int $order_id)
    {
        $order = Order::with([
            'shipments' => function ($query) {
                $query->orderBy('id', "desc");
            },
            'shipments.status',
            'shipments.packages' => function ($query) {
                $query->orderBy('id', "desc");
            },
            'shipments.packages.items' => function ($query) {
                $query->orderBy('id', "desc");
            },
            'shipments.packages.items.orderItemDiscounts',
            'shipments.packages.items.optionValues',
            'shipments.packages.items.optionValues.optionValue',
            'shipments.packages.items.optionValues.optionValue.option',
            'shipments.packages.items.discounts',
            'shipments.packages.items.product' => function ($query) {
                $query->withTrashed();
            },
            'shipments.distributor',
            'notes',
            'account',
            'affiliate',
            'billingAddress',
            'shippingAddress',
            'discounts'
        ])->find($order_id);

        // Calculate the properties
        $order->subTotal = $order->subTotal();
        $order->shippingTotal = $order->shippingTotal();
        $order->discountTotal = $order->discountTotal();
        $order->total = $order->total();
        $order->referralTotal = $order->referralTotal();

        return response($order, Response::HTTP_OK);
    }

    public function update(
        Order                 $order,
        UpdateOrderRequest $request
    ) {
        return response(
            UpdateOrder::now($order, $request->validated()),
            Response::HTTP_CREATED
        );
    }
}
