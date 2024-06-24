<?php

namespace App\Api\Orders\Controllers\Checkout;

use App\Api\Orders\Requests\OrderResourceRequest;
use App\Api\Orders\Resources\Order\OrderResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Support\Controllers\AbstractController;

class OrderController extends AbstractController
{
    //if order is completed, can call here to get it
    public function __invoke(OrderResourceRequest $request)
    {
        return [
            'order' => new OrderResource(
                $request->loadCheckoutByUuid()
                    ->orderCached()
                ?? throw new ModelNotFoundException(__('Order not found'))
            )
        ];
    }

//    public function store(CreateOrderForCheckoutRequest $request)
//    {
//        return [
//            'checkout' => new CheckoutResource(
//                CreateUpdateOrderForCheckout::now(
//                    $request->loadCheckoutByUuid()
//                )
//            )
//        ];
//    }

}
