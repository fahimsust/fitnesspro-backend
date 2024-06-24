<?php

namespace Domain\Orders\Actions\Order\Package\Accessories;

use Domain\Orders\Actions\Cart\Item\AddItemToCartFromDto;
use Domain\Orders\Actions\Cart\Item\LoadProductWithEntitiesForCartItem;
use Domain\Orders\Actions\Order\Package\Item\AddItemToOrderPackageFromDto;
use Domain\Orders\Actions\Order\Package\Item\LoadProductWithEntitiesActionForOrderItem;
use Domain\Orders\Dtos\AccessoryData;
use Domain\Orders\Dtos\CartItemDto;
use Domain\Orders\Dtos\OrderItemDto;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;
use Support\Contracts\CanReceiveExceptionCollection;
use Support\Traits\HasExceptionCollection;

class AddAccessoriesToOrderPackage
    extends AbstractAction
    implements CanReceiveExceptionCollection
{
    use         HasExceptionCollection;

    public Collection $addedOrderItems;

    public function __construct(
        public OrderPackage $package,
        public OrderItem    $item,
        public ?Collection  $productAccessoriesWithAccessoryDto = null
    )
    {
    }

    public function execute(): static
    {
        if (is_null($this->productAccessoriesWithAccessoryDto)) {
            return $this;
        }

        $this->addedOrderItems = collect();

        $this->productAccessoriesWithAccessoryDto
            ->map(
                fn(AccessoryData $accessoryData) => $this->buildOrderItemDtoForAccessory($accessoryData)
            )
            ->each(
                fn(OrderItemDto $dto) => $this->addToPackage($dto)
            );

        return $this;
    }

    private function buildOrderItemDtoForAccessory(AccessoryData $accessoryData): OrderItemDto
    {
        $itemDto = LoadProductWithEntitiesActionForOrderItem::run(
            $accessoryData->productId,
            $this->package->shipment->order->site
        )
            ->toOrderItemDto(
                $accessoryData->qty,
                $accessoryData->options
            );

        return $itemDto;
    }

    private function addToPackage(OrderItemDto $dto)
    {
        $this->addedOrderItems->push(
            AddItemToOrderPackageFromDto::run(
                $this->package->shipment,
                $this->package,
                $dto,
                checkRequiredAccessories: false
            )
                ->transferExceptionsTo($this)
                ->result()
        );
    }
}
