<?php

namespace Domain\Orders\Actions;

use Domain\Distributors\Actions\GetCalculatedAvailability;
use Domain\Products\Actions\LoadProductAvailabilityById;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAvailability;
use Support\Contracts\AbstractAction;

class GetProductAvailabilityForProduct extends AbstractAction
{
    public function __construct(
        public Product $product,
        public ?int    $distributorId = null,
        public bool    $useCache = true,
    )
    {
    }

    public function execute(): ProductAvailability
    {
        $availableStockQty = $this->product->combined_stock_qty;

        $availabilityId = $this->product->defaultOutOfStockStatusId()
            ?? $this->product->parent?->defaultOutOfStockStatusId();

        if (!$this->product->isInventoried() || !$this->distributorId) {
            return $this->load($availabilityId);
        }

        try {
            return GetCalculatedAvailability::now(
                $this->distributorId,
                $availableStockQty,
                $this->useCache
            );
        } catch (\Exception $exception) {
            if ($this->product->defaultAvailability?->id === $availabilityId) {
                return $this->product->defaultAvailability;
            }

            return $this->load($availabilityId);
        }
    }

    protected function load(int $availabilityId): ProductAvailability
    {
        return LoadProductAvailabilityById::now(
            $availabilityId,
            $this->useCache
        );
    }
}
