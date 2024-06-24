<?php

namespace Domain\Products\Actions\Categories\Query;

use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Category\Category;
use Domain\Products\QueryBuilders\ProductQuery;
use Domain\Products\ValueObjects\CategoryProductQueryParameters;
use Support\Contracts\AbstractAction;

class ApplyCategoryProductSearchCriteria extends AbstractAction
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
        if (!$this->params->search || $this->params->featuredOnly) {//if search and not featured
            return;
        }

        $this->query->where(
            fn($query) => $query->where("p.title", "LIKE", "%{$this->params->searchKeyword}%")
                ->orWhere("p.subtitle", "LIKE", "%{$this->params->searchKeyword}%")
                ->orWhere("p.meta_keywords", "LIKE", "%{$this->params->searchKeyword}%")
                ->orWhere("pd.description", "LIKE", "%{$this->params->searchKeyword}%")
        );

        $this->searchByAttributes();
        $this->searchByProductTypes();
        $this->searchByPovDate();
    }

    protected function searchByAttributes(): void
    {
        $search_attribute = collect($this->params->searchAttributes)
            ->filter(fn($val) => $val !== "");

        if ($search_attribute->isEmpty()) {
            return;
        }

//        $attributes = Attribute::query()
//            ->whereIn(
//                "id",
//                $search_attribute
//                ->keys()
//                ->toArray()
//            )
//            ->get();
//        $attribute_names = $attributes
//            ->pluck("name", "id")
//            ->toArray();

        $attributeValues = AttributeOption::query()
            ->select("id", "attribute_id", "display")
            ->where(
                fn($query) => $search_attribute
                    ->each(
                        fn($val, $attributeId) => $query->orWhere(
                            fn($query) => $query->where("attribute_id", $attributeId)
                                ->whereIn("id", (array)$val)
                        )
                    )
            )
            ->get();

//        $attributeValuesDisplay = $attributeValues
//            ->groupBy("attribute_id")
//            ->mapWithKeys(
//                fn($values, $attributeId) => [
//                    $attributeId => $values
//                        ->mapWithKeys(
//                            fn(AttributeOption $value) => [$value->id => $value->display]
//                        )
//                ]
//            );

        $this->query->whereJsonContains(
            "pd.attributes",
            $attributeValues->pluck('id')->toArray()
        );
    }

    protected function searchByProductTypes(): void
    {
        $search_type = $this->params->searchTypes;

        if (!$search_type) {
            return;
        }

        $this->query->whereIn(
            "pd.type_id",
            (array)$search_type
        );
    }

    protected function searchByPovDate(): void
    {
        $search_date = $this->params->searchDate;

        if (!$search_date) {
            return;
        }

        if (config('search.dates.show_thumbnail_search')) {
            $this->query
                ->addSelect("GROUP_CONCAT(DISTINCT CONCAT(search_pov.id, ':', search_pov.start_date,',',search_pov.end_date) SEPARATOR ';') as search_dates");
        }

        $this->query
            ->leftJoin(
                \DB::raw("products_options popt"),
                fn($join) => $join
                    ->on(
                        "popt.product_id",
                        "=",
                        "p.id"
                    )
                    ->whereRaw("p.has_children = 1")
                    ->whereRaw("popt.status = 1")
            )
            ->leftJoin(
                \DB::raw("products_options_values search_pov"),
                "search_pov.option_id",
                "=",
                "popt.id"
            )
            ->leftJoin(
                \DB::raw("products_children_options search_pov_pco"),
                "search_pov_pco.option_id",
                "=",
                "search_pov.id"
            )
            ->whereRaw("search_pov.status = 1")
            ->whereRaw("`search_pov_pco`.`product_id` = IF(`p`.`parent_product` > 0, `p`.`id`, `cp`.`id`)")
            ->whereRaw("search_pov_pco.status > ?", now())
            ->whereRaw("search_pov.start_date <= ?", $search_date)
            ->whereRaw("search_pov.end_date >= ?", $search_date);
    }
}
