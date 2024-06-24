<?php

namespace Domain\Products\Actions\Filter\Query;

use Domain\Products\Models\Brand;
use Domain\Products\QueryBuilders\ProductQuery;
use Support\Contracts\AbstractAction;

class BuildBrandsQueryFromProductQuery extends AbstractAction
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
                \DB::raw('b.id as value'),
                \DB::raw('b.name as display')
            )
            ->join(
                \DB::raw(Brand::Table() . ' b'),
                'b.id',
                '=',
                'pd.brand_id'
            )
            ->groupBy('b.id')
            ->orderBy('b.name');
    }
}

