<?php

namespace Domain\Products\Actions\Filter\Query;

use Domain\Products\QueryBuilders\ProductQuery;
use Support\Contracts\AbstractAction;

class BuildAttributeValuesQueryFromProductQuery extends AbstractAction
{
    public function __construct(
        public ProductQuery $query,
    )
    {
    }

    public function execute(): ProductQuery
    {
        return $this->query
            ->select(
                "attopt.attribute_id",
                \DB::raw("attopt.id as value"),
                "attopt.display"
            )
            ->join(
                \DB::raw("products_attributes" . " patt"),
                "patt.product_id",
                "=",
                "p.id"
            )
            ->join(
                \DB::raw("attributes_options" . " attopt"),
                "attopt.id",
                "=",
                "patt.option_id"
            )
            ->groupBy("attopt.id");
    }
}

