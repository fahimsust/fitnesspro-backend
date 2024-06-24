<?php

namespace Domain\Products\QueryBuilders;

use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Tests\Feature\Traits\CanSearchByKeyword;

class ProductOptionQuery extends Builder
{

    public function keywordSearch(?string $keyword)
    {
        return $this->like(['id', 'name', 'display'], $keyword);
    }

    public function forProduct(int $productId)
    {
        return $this->whereProductId($productId);
    }

    public function combinationQuery(int $productId): static
    {
        return $this
            ->select("id", "display")
            ->withWhereHas(
                'optionValues',
                fn($query) => $query
                    ->select("id", "option_id", ProductOptionValueQuery::realDisplaySelect())
                    ->where(ProductOptionValue::Table().'.status', true)
            )
            ->where('product_id', $productId)
            ->where('required', 1)
            ->where('status', 1)
            ->groupBy("id")
            ->orderBy("id", "ASC");
    }

    public function combinationOptionValuesGrouped(int $productId): static
    {
        return $this
            ->select(
                ProductOption::Table().".id",
                DB::raw("GROUP_CONCAT(".ProductOptionValue::Table().".id) as option_value_ids_string")
            )
            ->joinRelation(
                'optionValues',
                fn($join) => $join->where(ProductOptionValue::Table().'.status', true)
            )
            ->where(ProductOption::Table().'.product_id', $productId)
            ->where(ProductOption::Table().'.required', 1)
            ->where(ProductOption::Table().'.status', 1)
            ->groupBy(ProductOption::Table().".id")
            ->orderBy(ProductOption::Table().".id", "ASC");
    }
}
