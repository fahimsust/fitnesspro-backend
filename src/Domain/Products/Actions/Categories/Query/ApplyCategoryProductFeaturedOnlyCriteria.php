<?php

namespace Domain\Products\Actions\Categories\Query;

use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Category\Category;
use Domain\Products\QueryBuilders\ProductQuery;
use Domain\Products\ValueObjects\CategoryProductQueryParameters;
use Illuminate\Http\Request;
use Support\Contracts\AbstractAction;

class ApplyCategoryProductFeaturedOnlyCriteria extends AbstractAction
{
    public function __construct(
        public Category                       $category,
        public CategoryProductQueryParameters $params,
        public ProductQuery                   $query,
    )
    {
    }

    public function execute(): void
    {
        if (!$this->params->featuredOnly) {
            return;
        }

        $this->query->join(
            \DB::raw("categories_featured f"),
            "f.product_id",
            "=",
            "p.id"
        );

        $this->query->whereRaw("f.category_id = ?", $this->category->id);
    }
}
