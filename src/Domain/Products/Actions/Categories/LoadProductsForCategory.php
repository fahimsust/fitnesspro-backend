<?php

namespace Domain\Products\Actions\Categories;

use Domain\Products\Actions\Categories\Query\BuildCategoryProductQuery;
use Domain\Products\Models\Category\Category;
use Domain\Products\ValueObjects\CategoryProductQueryParameters;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadProductsForCategory extends AbstractAction
{
    public function __construct(
        public Category                       $category,
        public CategoryProductQueryParameters $params,
    )
    {
    }

    public function execute(): LengthAwarePaginator
    {
        return Cache::tags([
            "category-cache.{$this->category->id}"
        ])
            ->remember(
                'load-products-for-category.'
                . $this->category->id . '.'
                . $this->params->cacheKey(),
                60 * 10,
                fn() => $this->buildQuery()
            );
    }

    protected function buildQuery(): LengthAwarePaginator
    {
        $query = BuildCategoryProductQuery::now(
            $this->category,
            $this->params,
        );

//        echo $query->toRawSql()."\n";
//        dd(
//            $query->get()->toArray(),
//            ProductVariantOption::all()->toArray(),
//        );

        return $query->paginate(
            page: $this->params->page,
            perPage: $this->params->perPage
        );
    }
}
