<?php

namespace Domain\Orders\Dtos\Shipping;

use Spatie\LaravelData\Data;

class ShippingRateDto extends Data
{
    public float $originalPrice;

    public function __construct(
        public string                      $reference_name,
        public float                       $price,
        public ?int                        $id = null,
        public ?string                     $name = null,
        public ?string                     $display = null,
        public ?string                     $description = null,
        public ?AvailableShippingMethodDto $shippingMethodDto = null,
        public ?bool                       $callForEstimate = null,
        public bool                        $priceFinalized = false
    )
    {
        $this->originalPrice = $price;
    }

    public static function fromArray(array $data): static
    {
        return new static(
            reference_name: $data['reference_name'],
            price: $data['price'],
            id: $data['id'] ?? null,
            name: $data['name'] ?? null,
            display: $data['display'] ?? null,
            description: $data['description'] ?? null,
            shippingMethodDto: $data['shippingMethodDto'] ?? null,
            callForEstimate: $data['call_for_estimate'] ?? null,
            priceFinalized: $data['priceFinalized'] ?? false,
        );
    }

    public function finalizePrice(): static
    {
        if ($this->priceFinalized) {
            return $this;
        }

        if ($this->callForEstimate) {
            $this->price = 0;
            $this->priceFinalized = true;

            return $this;
        }

        $this->applyFlatRate();
        $this->applyDiscountRate();
        $this->applyHandlingFee();

        $this->priceFinalized = true;

        return $this;
    }

    public function applyFlatRate(): static
    {
        if (!$this->shippingMethodDto->flat_use) {
            return $this;
        }

        $this->price = $this->shippingMethodDto->flat_price;

        return $this;
    }

    public function applyDiscountRate(): static
    {
        if (!$this->shippingMethodDto->hasDiscountRate() || $this->price <= 0) {
            return $this;
        }

        $percent = bcsub(1, bcdiv($this->shippingMethodDto->discount_rate, 100, 4));
        $this->price = bcmul($this->price, $percent);

        return $this;
    }

    public function applyHandlingFee(): static
    {
        if (!$this->shippingMethodDto->hasHandlingFee()) {
            return $this;
        }

        if ($this->shippingMethodDto->handling_percentage > 0) {
            $percent = bcdiv($this->shippingMethodDto->handling_percentage, 100, 4);
            $this->price = bcadd($this->price, bcmul($this->price, $percent));

            return $this;
        }

        $this->price = bcadd($this->price, $this->shippingMethodDto->handling_fee);

        return $this;
    }

    public function toResource(): array
    {
        return [
            'id' => $this->id,
            'reference_name' => $this->reference_name,
            'price' => $this->price,
            'display' => $this->display,
            'description' => $this->description,
            'call_for_estimate' => $this->callForEstimate ?? false,
        ];
    }
}
