<?php

namespace App\Api\Admin\Orders\Controllers;

use App\Api\Admin\Orders\Requests\MoveOrderItemRequest;
use Domain\Orders\Actions\Order\Package\Item\MoveOrderItem;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MoveOrderItemController extends AbstractController
{
    public function __invoke(OrderPackage $package, OrderItem $item, MoveOrderItemRequest $request)
    {
        return response(
            MoveOrderItem::now($package, $item, $request),
            Response::HTTP_OK
        );
    }
}
