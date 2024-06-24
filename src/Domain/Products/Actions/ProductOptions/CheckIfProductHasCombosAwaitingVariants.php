<?php

namespace Domain\Products\Actions\ProductOptions;

use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class CheckIfProductHasCombosAwaitingVariants
{
    use AsObject;

    private Product $parentProduct;
    private bool $hasSome = false;
    private array $activeCombinationIds;

    public function handle(
        Product $parentProduct
    ): static
    {
        $this->activeCombinationIds = GetActiveCombinationValueIds::run($parentProduct);

        $totalActiveVariants = Product::query()
            ->where('parent_product', $parentProduct->id)
            ->where('status', 1)
            ->count('id');

        if (count($this->activeCombinationIds) > $totalActiveVariants) {
            $this->hasSome = true;
        }

        return $this;
    }

    public function hasSome(): bool
    {
        return $this->hasSome;
    }

    public function activeCombinationIds(): array
    {
        return $this->activeCombinationIds;
    }
}
