<?php

namespace App\Api\Admin\Orders\Controllers;

use Domain\Accounts\Models\Account;
use Domain\Orders\Enums\Checkout\CheckoutStatuses;
use Domain\Orders\Models\Checkout\Checkout;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Domain\Orders\Models\Order\Order;
use Domain\Sites\Models\Site;

class AbandonedOrdersController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            Checkout::where('status', CheckoutStatuses::Init)
    ->search($request->keyword)
    ->when(
        $request->filled('order_by'),
        function ($query) use ($request) {
            if (in_array($request->order_by, ['created_at'])) {
                // Directly sort by fields in the main table
                $query->orderBy($request->order_by, $request->order_type ?? 'asc');
            } elseif (in_array($request->order_by, ['email', 'first_name'])) {
                // Sort by related account fields using a subquery
                $query->orderBy(
                    Account::select($request->order_by)
                        ->whereColumn('accounts.id', 'checkouts.account_id'),
                    $request->order_type ?? 'asc'
                );
            } elseif ($request->order_by == 'order_no') {
                // Sort by related order fields using a subquery
                $query->orderBy(
                    Order::select('order_no')
                        ->whereColumn('orders.id', 'checkouts.order_id'),
                    $request->order_type ?? 'asc'
                );
            } elseif ($request->order_by == 'name') {
                // Sort by related site fields using a subquery
                $query->orderBy(
                    Site::select('name')
                        ->whereColumn('sites.id', 'checkouts.site_id'),
                    $request->order_type ?? 'asc'
                );
            }
        }
    )
    ->with([
        'account',
        'order',
        'site',
    ])
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }

    public function show(int $checkout_id)
    {
        return response(
            Checkout::with(
                'order',
                'shipments',
                'items',
                'items.cartItem',
                'items.cartItem.product',
                'items.cartItem.optionValues',
                'items.cartItem.optionValues.optionValue',
                'items.cartItem.optionValues.optionValue.option',
                'items.discounts',
                'billingAddress',
                'shippingAddress',
                'order',
                'order.checkoutDiscounts',
                'order.checkoutDiscounts.discount'
            )->find($checkout_id),
            Response::HTTP_OK
        );
    }
}
