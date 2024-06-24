<?php

namespace Domain\Orders\Actions\Order\Package\Item;

use Domain\Distributors\Actions\LoadDistributorByIdFromCache;
use Domain\Orders\Dtos\OrderItemDto;
use Domain\Products\Contracts\LoadProductWithEntitiesAction;

class LoadProductWithEntitiesActionForOrderItem extends LoadProductWithEntitiesAction
{
    public function toOrderItemDto(
        int    $orderQty,
        ?array $optionCustomValues = null,
        ?array $customFieldValues = null,
        ?array $accessories = null,
    ): OrderItemDto
    {
        $dto = (new OrderItemDto(
            $this->site,
            $this->product,
            $orderQty,
        ))
            ->pricing($this->loadPricingBySite())
            ->availability($this->productAvailability);

        if ($optionCustomValues) {
            $dto->optionValues($optionCustomValues);
        }

        if ($customFieldValues) {
            $dto->customFields($customFieldValues);
        }

        if ($accessories) {
            $dto->accessories($accessories);
        }

        if ($this->distributorId()) {
            $dto->distributor(LoadDistributorByIdFromCache::now($this->distributorId()))
                ->productDistributor($this->productDistributor);
        }

        return $dto;
    }
}
