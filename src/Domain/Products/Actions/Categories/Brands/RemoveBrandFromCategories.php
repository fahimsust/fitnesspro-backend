<?php

namespace Domain\Products\Actions\Categories\Brands;

use Domain\Products\Models\Brand;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class RemoveBrandFromCategories
{
    use AsObject;

    public function handle(
        Brand $brand,
        Collection $categoryIds
    ): int {
        return $brand->categoryBrands()
            ->whereIn('category_id', $categoryIds)
            ->delete();
    }
}
