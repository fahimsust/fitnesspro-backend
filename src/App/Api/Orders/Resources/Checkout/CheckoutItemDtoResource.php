<?php

namespace App\Api\Orders\Resources\Checkout;

use Domain\Orders\Dtos\CheckoutItemDto;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckoutItemDtoResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var CheckoutItemDto $dto */
        $dto = $this->resource;

        return array_filter([
            'price_reg' => $dto->priceReg,
            'price_sale' => $dto->priceSale,
            'onsale' => $dto->onSale,
            'label' => $dto->label,
            'product_id' => $dto->product->id,
            'title' => $dto->product->title,
            'availability' => $dto->availability?->toArray(),
            'combined_qty' => $dto->product->combined_stock_qty,
            'distributor_qty' => $dto->productDistributor?->stock_qty,
            'package_qty' => $dto->orderQty,
        ], fn($value) => $value !== null);
    }
}
