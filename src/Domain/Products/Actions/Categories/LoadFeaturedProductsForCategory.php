<?php

namespace Domain\Products\Actions\Categories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadFeaturedProductsForCategory extends AbstractAction
{
    public function __construct(
        public int $categoryId,
    )
    {
    }

    public function execute(): Collection
    {
        return Cache::tags([
            "category-cache.{$this->categoryId}"
        ])
            ->remember(
                'load-featured-products-for-category.' . $this->categoryId,
                60 * 5,
                fn() => LoadCategoryById::now($this->categoryId)
                    ->featuredProducts()
                    ->get()
            );
    }
}
