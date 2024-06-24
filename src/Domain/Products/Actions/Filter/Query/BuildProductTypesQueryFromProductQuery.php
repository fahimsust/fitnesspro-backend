<?php

namespace Domain\Products\Actions\Filter\Query;

use Domain\Products\Models\Product\ProductType;
use Domain\Products\QueryBuilders\ProductQuery;
use Support\Contracts\AbstractAction;

class BuildProductTypesQueryFromProductQuery extends AbstractAction
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
                \DB::raw('pt.id as value'),
                \DB::raw('pt.name as display')
            )
            ->join(
                \DB::raw(ProductType::Table() . ' pt'),
                'pt.id',
                '=',
                'pd.type_id'
            )
            ->groupBy('pt.id')
            ->orderBy('pt.name');
    }
}

