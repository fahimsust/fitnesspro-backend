<?php

namespace Domain\Products\Actions\ProductOptions;

use App\Api\Admin\Products\Requests\CreateProductVariantRequest;
use Domain\Products\Actions\Product\CreateProductVariant;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateVariantUsingOptionValueIds
{
    use AsObject;

    protected Product $parentProduct;
    protected array $optionValueIds;
    private ?Collection $productOptionValues = null;

    private function handle(
        Product $parentProduct,
        array $optionValueIds,
        int $stockQty = 1,
        ?Collection $productOptionValues = null,
    ): ?Product
    {
        $this->parentProduct = $parentProduct;
        $this->optionValueIds = $optionValueIds;

        if ($this->variantOptionAlreadyExists()) {
            return null;
        }

        $this->productOptionValues = $productOptionValues;

        $names = $this->getProductOptionValues()
            ->whereIn('id', $this->optionValueIds)
            ->map(
                fn(ProductOptionValue $optionValue) => $optionValue->real_display
            );

        return CreateProductVariant::run(
            $this->parentProduct,
            new CreateProductVariantRequest(
                [
                    'options' => $this->optionValueIds,
                    'stock_qty' => $stockQty,
                    'title' => $names->implode(" - "),
                    'url' => Str::slug($names->implode("-")),
                    'status' => false,
                ]
            )
        );
    }

    protected function getProductOptionValues(): Collection
    {
        return $this->productOptionValues ??= GetProductOptionValuesForCombinationIds::run(
            $this->optionValueIds
        );
    }

    protected function variantOptionAlreadyExists(): bool
    {
        return (bool)Product::select("id")
            ->where('parent_product', $this->parentProduct->id)
            ->whereHas(
                'variantOptions',
                fn(Builder $query) => $query->whereIn('option_id', $this->optionValueIds),
                '=',
                count($this->optionValueIds)
            )
            ->count();
    }
}
