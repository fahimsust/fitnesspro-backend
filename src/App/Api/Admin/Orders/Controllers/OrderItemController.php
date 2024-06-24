<?php

namespace App\Api\Admin\Orders\Controllers;

use App\Api\Admin\Orders\Requests\AddProductToOrderPackageRequest;
use App\Api\Admin\Orders\Requests\UpdateQtyOrderItemRequest;
use Domain\Orders\Actions\Order\Package\Item\AddProductToOrderPackage;
use Domain\Orders\Actions\Order\Package\Item\DeleteOrderItem;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class OrderItemController extends AbstractController
{
    public function store(OrderPackage $package, AddProductToOrderPackageRequest $request)
    {
        return response(
            AddProductToOrderPackage::now($package, $request)
                ->createdOrderItem
                ->toArray(),
            Response::HTTP_CREATED
        );
    }

    public function destroy(OrderPackage $package, OrderItem $item)
    {
        return response(
            DeleteOrderItem::now($package, $item, true),
            Response::HTTP_OK
        );
    }

    public function update(
        OrderPackage              $package,
        OrderItem                 $item,
        UpdateQtyOrderItemRequest $request
    )
    {
        return response(
            $item->update(['product_qty' => $request->product_qty]),
            Response::HTTP_OK
        );
    }
}
