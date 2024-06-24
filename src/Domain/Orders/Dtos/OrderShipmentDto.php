<?php

namespace Domain\Orders\Dtos;

use Domain\Future\GiftRegistry\GiftRegistry;
use Domain\Orders\Collections\OrderPackageDtosCollection;
use Domain\Orders\Contracts\ShipmentDto;
use Domain\Orders\Models\Checkout\CheckoutShipment;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Domain\Orders\Models\Order\Shipments\ShipmentStatus;
use Domain\Orders\Traits\IsShipmentDto;
use Spatie\LaravelData\Data;

class OrderShipmentDto extends Data
    implements ShipmentDto
{
    use IsShipmentDto;

    public ?Order $order = null;
    public ?Shipment $shipment = null;

    public ?string $trackingNumber = null;
    public ?ShipmentStatus $status = null;

    public function trackingNumber(?string $trackingNumber): static
    {
        $this->trackingNumber = $trackingNumber;

        return $this;
    }

    public function status(?ShipmentStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public static function fromCartItemWithOrderItemDto(
        CartItemWithOrderItemDto $item,
    ): static
    {
        return new static(
            isDigital: $item->cartItem->product->isDigital(),
            distributorId: $item->orderItemDto->distributor->id,
            distributor: $item->orderItemDto->distributor,
            registry: $item->cartItem->isRegistryItem()
                ? $item->cartItem->registryItem->registry
                : null
        );
    }

    public static function fromCheckoutShipmentDto(
        CheckoutShipmentDto $dto
    ): static
    {
        return new static(
            isDigital: $dto->isDigital,
            isDropShip: $dto->isDropShip,
            shipCost: $dto->shipCost,
            shippingMethodId: $dto->shippingMethodId,
            distributorId: $dto->distributorId,
            packages: OrderPackageDtosCollection::fromCheckoutPackageDtos(
                $dto->packages
            ),
            registry: $dto->registry
        );
    }

    public static function fromCheckoutShipmentModel(
        CheckoutShipment $shipment
    ): static
    {
        return new static(
            isDigital: $shipment->is_digital,
            isDropShip: $shipment->is_drop_ship,
            shipCost: $shipment->shipping_cost ?? 0,
            shippingMethodId: $shipment->shipping_method_id,
            distributorId: $shipment->distributor_id,
            packages: OrderPackageDtosCollection::fromCheckoutShipmentModel(
                $shipment
            ),
            registry: $shipment->loadMissingReturn('registry')
        );
    }

    public static function withPackage(
        OrderPackageDto $package,
        int             $distributorId,
        bool            $isDownloads,
        ?GiftRegistry   $registry = null
    )
    {
        return new static(
            isDigital: $isDownloads,
            distributorId: $distributorId,
            packages: new OrderPackageDtosCollection([$package]),
            registry: $registry
        );
    }

    public function order(Order $order): static
    {
        $this->order = $order;

        return $this;
    }

    public function toOrderShipmentModel(
        ?int $defaultStatus = null
    ): array
    {
        return [
            'order_id' => $this->order->id,
            'ship_method_id' => $this->shippingMethodId,
            'ship_cost' => $this->shipCost,
            'order_status_id' => $defaultStatus ?? $this->status,
            'distributor_id' => $this->distributorId,
            'is_downloads' => $this->isDigital
        ];
    }
}
