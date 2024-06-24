<?php

namespace App\Api\Orders\Resources\Checkout;

use Domain\Orders\Dtos\CheckoutShipmentDto;
use Illuminate\Http\Resources\Json\JsonResource;

class ShipmentDtoResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var CheckoutShipmentDto $dto */
        $dto = $this->resource;

        return array_filter([
            'id' => $dto->id,
            'weight' => $dto->weight(),
            'distributor_id' => $dto->distributor?->id ?? $dto->distributorId,
            'registry' => $dto->registry?->toArray(),
            'packages' => PackageDtoResource::collection($dto->packages),
            'rates' => ShippingRateDtoResource::collection($dto->rates),
            'is_drop_ship' => $dto->isDropShip,
            'is_digital' => $dto->isDigital,
            'shipping_method' => $dto->shippingMethodId > 0
                ? [
                    'id' => $dto->shippingMethodId,
                    'label' => $dto->shippingMethodLabel,
                    'cost' => $dto->shipCost,
                ]
                : null,
        ], fn($value) => $value !== null);
    }
}
