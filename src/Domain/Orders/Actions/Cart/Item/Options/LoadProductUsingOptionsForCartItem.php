<?php

namespace Domain\Orders\Actions\Cart\Item\Options;

use Domain\Distributors\Actions\GetCalculatedAvailability;
use Domain\Distributors\Models\Distributor;
use Domain\Future\GiftRegistry\RegistryItem;
use Domain\Orders\Actions\Cart\Item\LoadProductWithEntitiesForCartItem;
use Domain\Orders\Dtos\CartItemDto;
use Domain\Products\Actions\ProductOptions\GetOptionsForVariant;
use Domain\Products\Actions\ProductOptions\GetOptionsPricingAndCustom;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAvailability;
use Domain\Products\Models\Product\ProductDistributor;
use Domain\Sites\Models\Site;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsObject;

class LoadProductUsingOptionsForCartItem
{
    use AsObject;

    public ?int $calculatedCost;

    public Site $site;
    public ?ProductDistributor $productDistributor = null;
    public ProductAvailability $productAvailability;
    public Product $product;

    public int $availableStockQty = 0;
    public int $availabilityId;
    public int $outOfStockStatusId;

    public array $options = [];

    public ?RegistryItem $registryItem = null;

    public function handle(
        int $childProductId,
        Site $site,
        ?array $options = null,
        ?int $childOf = null
    ): static {
        if ($childOf) {
            return LoadProductWithEntitiesForCartItem::run(
                $childOf,
                $site,
                $options ?? GetOptionsForVariant::run($childProductId)
            );
        }

        $this->site = $site;
        $this->options = $options;

        $this->product = Product::query()
            ->whereId($childProductId)
            ->withSum(
                'children',
                'combined_stock_qty'
            )
            ->with([
                'fulfillmentRule',
                'availability',
                'details' => [
                    'brand',
                    'category',
                    'type',
                ],
                'attributeOptions',
            ])
            ->firstOrFail();

        CheckOptionsAgainstProductRequiredOptions::run($this->product->id, $this->options);

        if ($this->distributorId()) {
            $this->productDistributor = ProductDistributor::with('distributor')
                ->whereDistributorId(
                    $this->distributorId()
                )
                ->first();
        }

        $this->calculatedCost = $this->product->pricingBySiteCached($this->site)->default_cost
            ?? $this->product->default_cost;

        $this->availableStockQty = $this->isParent() && $this->product->children_sum_combined_stock_qty
            ? $this->product->children_sum_combined_stock_qty
            : $this->product->combined_stock_qty;

        $this->productAvailability = $this->calculateAvailability();

        GetOptionsPricingAndCustom::run($this->options);

        return $this;
    }

    public function inventoryId(): ?string
    {
        return $this->productDistributor?->inventory_id;
    }

    public function isRegistryItem(int $registryItemId): static
    {
        $this->registryItem = RegistryItem::select(
            RegistryItem::Table() . '.*',
            'registry.registry_name',
            'registry.event_date',
            'registry.ship_to',
            DB::raw('(qty_wanted - qty_purchased) as qty_needed')
        )
            ->joinRelationship(
                'registry',
                fn ($join) => $join->as('registry')
            )
            ->whereRegistryItemId($registryItemId)
            ->firstOrFail();

        if ($this->registryItem->event_date < now()) {
            throw new \Exception(__('The event date for this gift registry item has passed, so it can not be loaded into your cart.'));
        }

        return $this;
    }

    public function toCartItemDto(): CartItemDto
    {
        $dto = (new CartItemDto(
            $this->site,
            $this->product,
            1,
        ))
            ->availableStockQty($this->availableStockQty)
            ->pricing($this->product->pricingBySiteCached($this->site))
            ->availability($this->productAvailability)
            ->optionValues($this->options)
            ->registryItem($this->registryItem);

        if ($this->distributorId()) {
            $dto
                ->distributor(Distributor::find($this->distributorId()))
                ->productDistributor($this->productDistributor);
        }

        return $dto;
    }

    private function calculateAvailability(): ProductAvailability
    {
        $this->availabilityId = $this->outOfStockStatusId = $this->product->pricingBySiteCached($this->site)?->default_outofstockstatus_id
            ?? $this->product->default_outofstockstatus_id;

        if (! $this->product->inventoried || ! $this->distributorId()) {
            return ProductAvailability::find($this->availabilityId);
        }

        try {
            return GetCalculatedAvailability::run(
                $this->distributorId(),
                $this->availableStockQty
            );
        } catch (\Exception $exception) {
            if ($this->product->availability->id === $this->availabilityId) {
                return $this->product->availability;
            }

            return ProductAvailability::find($this->availabilityId);
        }
    }

    private function isParent(): bool
    {
        return (bool) $this->product->parent_product;
    }

    private function distributorId(): ?int
    {
        return $this->product->pricingBySiteCached($this->site)?->default_distributor_id
            ?? $this->product->default_distributor_id;
    }
}
