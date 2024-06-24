<?php

namespace Domain\Orders\Actions\Cart\Item;

use Domain\Distributors\Actions\LoadDistributorByIdFromCache;
use Domain\Orders\Dtos\CartItemDto;
use Domain\Products\Contracts\LoadProductWithEntitiesAction;

class LoadProductWithEntitiesForCartItem extends LoadProductWithEntitiesAction
{

    public function toCartItemDto(
        int    $orderQty,
        ?array $optionCustomValues = null,
        ?array $customFieldValues = null,
        ?array $accessories = null,
    ): CartItemDto
    {
        $dto = (new CartItemDto(
            $this->site,
            $this->product,
            $orderQty,
        ))
            ->availableStockQty($this->availableStockQty)
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
