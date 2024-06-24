<?php

namespace App\Api\Orders\Resources\Checkout;

use Domain\Orders\Dtos\Shipping\ShippingRateDto;
use Illuminate\Http\Resources\Json\JsonResource;

class ShippingRateDtoResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var ShippingRateDto $dto */
        $dto = $this->resource;

        return $dto->toResource();
    }
}
