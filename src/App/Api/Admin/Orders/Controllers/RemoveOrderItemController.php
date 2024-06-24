<?php

namespace App\Api\Admin\Orders\Controllers;

use App\Api\Admin\Orders\Requests\OrderItemsRequest;
use Domain\Orders\Actions\Order\Package\Item\DeleteOrderItems;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RemoveOrderItemController extends AbstractController
{
    public function __invoke(OrderPackage $package, OrderItemsRequest $request)
    {
        return response(
            DeleteOrderItems::now($package,$request->items),
            Response::HTTP_OK
        );
    }
}
