<?php

namespace App\Api\Orders\Resources\Checkout;

use Domain\Orders\Dtos\CheckoutPackageDto;
use Domain\Orders\Dtos\OrderPackageDto;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageDtoResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var CheckoutPackageDto $dto */
        $dto = $this->resource;

        return array_filter([
            'shipment' => $dto->shipment?->toArray(),
            'weight' => $dto->weight(),
            'items' => CheckoutItemDtoResource::collection($dto->items),
        ], fn($value) => $value !== null);
    }
}
