<?php

namespace Domain\Products\Actions\Categories\Query;

use Domain\Products\Actions\Product\Query\BuildProductQuery;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryFeaturedProduct;
use Domain\Products\QueryBuilders\ProductQuery;
use Domain\Products\ValueObjects\CategoryProductQueryParameters;
use Support\Contracts\AbstractAction;

class BuildCategoryProductQuery extends AbstractAction
{
    private ProductQuery $productQuery;
    private ProductQuery $query;

    public function __construct(
        public Category                       $category,
        public CategoryProductQueryParameters $params,
    )
    {
        $this->productQuery = BuildProductQuery::now($params);

//        if (
//            $this->category->filters->isNotEmpty()
//            && $this->params->featuredOnly == 0
//        ) {
//            $this->params->filters = $this->category->filters;//don't apply filters for featured products
//        }
    }

    public function execute(): ProductQuery
    {
        $this->query = clone $this->productQuery;

        $this->buildIsFeaturedSelect();

        ApplyCategoryProductFeaturedOnlyCriteria::now(
            $this->category,
            $this->params,
            $this->query
        );

        ApplyCategoryProductNonFeaturedCriteria::now(
            $this->category,
            $this->params,
            $this->query
        );

        ApplyCategoryProductSearchCriteria::now(
            $this->category,
            $this->params,
            $this->query
        );

//        if (!$this->params->is_filter) {
//            echo $this->query->toRawSql()."\n";
//        }

        return $this->query;
    }

    protected function buildIsFeaturedSelect(): void
    {
        if (
            $this->params->featuredOnly
            || $this->category
                ->calculatedSetting('show_products')
                ->useSettings()
            || $this->category->rules->isEmpty()
        ) {
            return;
        }

        $this->query->addSelect("f.product_id as isFeatured");
    }
}
