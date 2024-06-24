<?php

namespace Domain\Products\Actions\ProductOptions;

use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateVariantsFromUnassignedOptionValues
{
    use AsObject;

    private int $productId;
    private int $totalActiveCombinations;
    private int $totalActiveVariants;
    private int $missingVariantOptions;

    private bool $createChildrenAutomatically = true;
    private Product $parentProduct;
    private array $emptyChild;

    public Collection $variants;
    private Collection $activeCombinationIds;

    public function handle(
        Product $product,
    ): ?Collection
    {
        $this->parentProduct = $product;
        $this->productId = $product->id;
        $this->variants = new Collection();

        if (!$this->hasWaitingCombos()) {
            return null;
        }

        $this->addCombos();

        return $this->variants;
    }

    private function hasWaitingCombos(): bool
    {
        $checker = CheckIfProductHasCombosAwaitingVariants::run($this->parentProduct);
        $this->activeCombinationIds = collect($checker->activeCombinationIds());

        return $checker->hasSome();
    }

    private function addCombos(bool $override = false): void
    {
        $this->variants = CreateVariantsWithOptionValueIds::run(
            $this->parentProduct,
            $this->activeCombinationIds,
            $override
        );
    }
}
