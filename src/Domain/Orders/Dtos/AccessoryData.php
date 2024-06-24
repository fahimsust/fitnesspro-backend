<?php

namespace Domain\Orders\Dtos;

use Domain\Products\Models\Product\ProductAccessory;
use Spatie\LaravelData\Data;

class AccessoryData extends Data
{
    public ?ProductAccessory $productAccessory = null;

    public function __construct(
        public int $productId,
        public int $qty,
        public array $options = [],
    ) {
    }

    public function toArray(): array
    {
        return [
        ];
    }

    public function setProductAccessory(ProductAccessory $productAccessory): static
    {
        $this->productAccessory = $productAccessory;

        return $this;
    }
}
