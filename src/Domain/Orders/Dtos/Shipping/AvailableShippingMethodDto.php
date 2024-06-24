<?php

namespace Domain\Orders\Dtos\Shipping;

use Spatie\LaravelData\Data;

class AvailableShippingMethodDto extends Data
{
    public function __construct(
        public int    $id,
        public string $reference_name,
        public string $name,
        public string $display,
        public int    $carrier_id,
        public bool   $ships_residentials,
        public bool   $is_international,
        public float  $price,
        public string $carrier_code,
        public int    $rank,
        public int    $weight_limit,
        public int    $weight_min,
        public int    $distributor_shippingmethod_id,
        public bool   $call_for_estimate,
        public bool   $flat_use,
        public float  $flat_price,
        public float  $handling_fee,
        public float  $handling_percentage,
        public float  $discount_rate,
        public int    $gateway_id,
        public string $gateway_class,
        public int    $distributor_id
    )
    {
    }

    public static function fromQuery(object $result): self
    {
        return new self(
            id: $result->id,
            reference_name: $result->refname,
            name: $result->name,
            display: $result->display,
            carrier_id: $result->carrier_id,
            ships_residentials: $result->ships_residential,
            is_international: $result->is_international,
            price: $result->price,
            carrier_code: $result->carriercode,
            rank: $result->rank,
            weight_limit: $result->weight_limit,
            weight_min: $result->weight_min,
            distributor_shippingmethod_id: $result->distributor_shippingmethod_id,
            call_for_estimate: $result->call_for_estimate,
            flat_use: $result->flat_use,
            flat_price: $result->flat_price,
            handling_fee: $result->handling_fee,
            handling_percentage: $result->handling_percentage,
            discount_rate: $result->discount_rate,
            gateway_id: $result->gateway_id,
            gateway_class: $result->gateway_class,
            distributor_id: $result->distributor_id,
        );
    }

    public function minWeight(): ?float
    {
        return $this->weight_min ?: null;
    }

    public function maxWeight(): ?float
    {
        return $this->weight_limit ?: null;
    }

    public function minWeightCheck(float $weight): bool
    {
        return $this->minWeight() === null || $weight >= $this->minWeight();
    }

    public function maxWeightCheck(float $weight): bool
    {
        return $this->maxWeight() === null || $weight <= $this->maxWeight();
    }

    public function canHandleWeight(float $weight): bool
    {
        return $this->minWeightCheck($weight) && $this->maxWeightCheck($weight);
    }

    public function hasDiscountRate(): bool
    {
        return $this->discount_rate > 0;
    }

    public function hasHandlingFee(): bool
    {
        return $this->handling_fee > 0 || $this->handling_percentage > 0;
    }
}
