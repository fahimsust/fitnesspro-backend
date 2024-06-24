<?php

namespace Domain\Products\Actions\Categories\Query;

use Domain\Products\Models\Category\Category;
use Domain\Products\QueryBuilders\ProductQuery;
use Domain\Products\ValueObjects\CategoryProductQueryParameters;
use Support\Contracts\AbstractAction;

class ApplyCategoryProductNonFeaturedCriteria extends AbstractAction
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
        if ($this->params->featuredOnly) {
            return;
        }

        $this->joinCategoryAssn();

        $this->applyHideCriteria();

        if (!$this->params->manuallyRelatedOnly) {
            $this->applyProductTypeCriteria();
            $this->applyBrandCriteria();
        }

        $this->applySaleCriteria();
        $this->applyPriceCriteria();

        $this->applyLimitDays();

        if (
            $this->category->show_products == 1
            || $this->category->show_products == 2
        ) {//show manually related products
            $this->query->whereRaw(
                "cpa.category_id = ?",
                $this->category->id
            );
        }
    }

    protected function joinCategoryAssn(): void
    {
        if ($this->params->manuallyRelatedOnly) {//show manually related products only
            $this->query->join(
                \DB::raw("categories_products_assn cpa"),
                fn($join) => $join
                    ->when(
                        $this->params->includeParentChildren->parentsOnly(),
                        fn($join) => $join
                            ->on(
                                "cpa.product_id",
                                "=",
                                "p.id"
                            ),
                        fn($join) => $join
                            ->on(
                                "cpa.product_id",
                                "=",
                                \DB::raw("IFNULL(par.id, p.id)")
                            )
                    )
                    ->whereRaw("cpa.manual=1")
            );

            return;
        }

        if ($this->category->rules->isNotEmpty()) {
            $this->query
                ->join(
                    \DB::raw("categories_products_assn cpa"),
                    fn($join) => $join
                        ->when(
                            $this->params->includeParentChildren->parentsOnly(),
                            fn($join) => $join
                                ->on(
                                    "cpa.product_id",
                                    "=",
                                    "p.id"
                                ),
                            fn($join) => $join
                                ->on(
                                    "cpa.product_id",
                                    "=",
                                    \DB::raw("IFNULL(par.id, p.id)")
                                )
                        )
                        ->when(
                            $this->category->show_products == 0,
                            fn($join) => $join->whereRaw("cpa.manual=0")
                        )
                )
                ->when(
                    $this->params->featuredShow == 1,
                    fn($join) => $join->leftJoin(
                        \DB::raw("categories_featured f"),
                        fn($join) => $join
                            ->on(
                                "f.product_id",
                                "=",
                                "p.id"
                            )
                            ->where(
                                "f.category_id",
                                $this->category->id
                            )
                    )
                );
        }
    }

    protected function applyProductTypeCriteria(): void
    {
        if (!$this->category->hasProductTypeFiltering()) {
            return;
        }

        $this->query->when(
            $this->category->show_types == 1,
            fn($query) => $query->whereIn(
                "pd.type_id",
                $this->category->types->pluck("id")
            ),
            fn($query) => $query->whereNotIn(
                "pd.type_id",
                $this->category->types->pluck("id")
            )
        );
    }

    protected function applyBrandCriteria(): void
    {
        if ($this->category->brands->isEmpty()) {
            return;
        }

        $this->query->when(
            $this->category->show_brands == 1,
            fn($query) => $query->whereIn(
                "pd.brand_id",
                $this->category->brands->pluck("brand_id")
            ),
            fn($query) => $query->whereNotIn(
                "pd.brand_id",
                $this->category->brands->pluck("brand_id")
            )
        );
    }

    protected function applySaleCriteria(): void
    {
        if ($this->category->show_sale == 1) {//Only get items onsale
            if ($this->params->includeParentChildren->parentsOnly()) {
                $this->query->whereRaw("IFNULL(cpp.onsale, pp.onsale)=1");

                return;
            }

            $this->query->whereRaw("pp.onsale = 1");

            return;
        }

        if ($this->category->show_sale == 2) {//Only get items not on sale
            $this->query->whereRaw("pp.onsale = 0");

            if ($this->params->includeParentChildren->parentsOnly()) {
                $this->query->whereRaw("(cpp.onsale IS NULL OR cpp.onsale=0)");
            }
        }
    }

    protected function applyPriceCriteria(): void
    {
        if ($this->category->limit_min_price == 1) {
            $this->query->whereRaw(
                "IF(pp.onsale != 0, pp.price_sale, pp.price_reg) >= ?",
                $this->category->min_price
            );
        }

        if ($this->category->limit_max_price == 1) {
            $this->query->whereRaw(
                "IF(pp.onsale != 0, pp.price_sale, pp.price_reg) <= ?",
                $this->category->max_price
            );
        }
    }

    protected function applyHideCriteria(): void
    {
        $this->query->leftJoin(
            \DB::raw("categories_products_hide hide"),
            fn($join) => $join
                ->when(
                    $this->params->includeParentChildren->parentsOnly(),
                    fn($join) => $join
                        ->on(
                            "hide.product_id",
                            "=",
                            "p.id"
                        ),
                    fn($join) => $join
                        ->on(
                            "hide.product_id",
                            "=",
                            \DB::raw("IFNULL(par.id, p.id)")
                        )
                )
                ->where(
                    "hide.category_id",
                    $this->category->id
                )
        );

        $this->query->whereRaw("hide.product_id IS NULL");
    }

    protected function applyLimitDays(): void
    {
        if ($this->category->limit_days <= 0) {
            return;
        }

        $day = now()->subDays($this->category->limit_days)->startOfDay();
        $this->query->whereRaw(
            "IFNULL(pp.published_date, p.created) >= ?",
            $day
        );
    }
}
