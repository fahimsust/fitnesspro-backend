<?php

namespace Domain\Products\Contracts;

use Domain\Future\GiftRegistry\RegistryItem;
use Domain\Orders\Actions\Cart\Item\LoadProductForCartItem;
use Domain\Orders\Actions\GetProductAvailabilityForProduct;
use Domain\Products\Actions\Distributors\LoadProductDistributorWithDistributor;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAvailability;
use Domain\Products\Models\Product\ProductDistributor;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\Site;
use Support\Contracts\AbstractAction;

abstract class LoadProductWithEntitiesAction extends AbstractAction
{
    public ?int $calculatedCost;

    public ?ProductDistributor $productDistributor = null;
    public ProductAvailability $productAvailability;
    public Product $product;

    public int $availableStockQty = 0;
    public int $availabilityId;

    public ?RegistryItem $registryItem = null;

    private ?int $overrideDistributorId = null;

    public function __construct(
        public int  $childProductId,
        public Site $site,
        public bool $useCache = true,
    )
    {
    }

    public function overrideDistributorId(?int $distributorId): static
    {
        $this->overrideDistributorId = $distributorId;

        return $this;
    }

    public function execute(): static
    {
        $this->product = LoadProductForCartItem::now(
            $this->childProductId,
            $this->useCache
        );

        if ($this->distributorId()) {
            $this->productDistributor = LoadProductDistributorWithDistributor::now(
                $this->childProductId,
                $this->distributorId(),
                $this->useCache
            );

            $this->availableStockQty = $this->productDistributor->stock_qty;
        } else {
            $this->availableStockQty = $this->product->combined_stock_qty;
        }

        $this->calculatedCost = $this->product->defaultCost();

        $this->productAvailability = GetProductAvailabilityForProduct::run(
            $this->product,
            $this->distributorId()
        );

        return $this;
    }

    public static function run(...$args): static
    {
        return parent::run(...$args);
    }

    public static function now(...$args): static
    {
        return parent::now(...$args);
    }

    public function inventoryId(): ?string
    {
        return $this->productDistributor?->inventory_id;
    }


    protected function distributorId(): ?int
    {
        if($this->overrideDistributorId) {
            return $this->overrideDistributorId;
        }

        return $this->loadPricingBySite()?->default_distributor_id
            ?? $this->product->defaultDistributorId();
    }

    protected function loadPricingBySite(): ProductPricing
    {
        if (!$this->useCache) {
            return $this->product->pricingBySite($this->site);
        }

        return $this->product->pricingBySiteCached($this->site);
    }
}
