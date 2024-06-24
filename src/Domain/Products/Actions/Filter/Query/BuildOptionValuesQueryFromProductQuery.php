<?php

namespace Domain\Products\Actions\Filter\Query;

use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\QueryBuilders\ProductQuery;
use Domain\Products\ValueObjects\ProductQueryParameters;
use Support\Contracts\AbstractAction;

class BuildOptionValuesQueryFromProductQuery extends AbstractAction
{
    public function __construct(
        public ProductQuery           $query,
        public ProductQueryParameters $params,
    )
    {
    }

    public function execute(): ProductQuery
    {
        return $this->query
            ->select(
                'popt.name',
                \DB::raw("GROUP_CONCAT(DISTINCT poptval.id ORDER BY poptval.id) as value"),
                \DB::raw("poptval.name as display")
            )
            ->join(
                \DB::raw(ProductOption::Table() . ' popt'),
                fn($join) => $join
                    ->when(
                        $this->params->includeParentChildren->parentsOnly(),
                        fn($join) => $join->on(
                            'popt.product_id',
                            '=',
                            'p.id'
                        ),
                        fn($join) => $join->on(
                            'popt.product_id',
                            '=',
                            \DB::raw('IFNULL(par.id, p.id)')
                        )
                    )
            )
            ->join(
                \DB::raw('products_options_values' . ' poptval'),
                'poptval.option_id',
                '=',
                'popt.id'
            )
            ->join(
                \DB::raw('products_children_options' . ' pco'),
                fn($join) => $join
                    ->when(
                        $this->params->includeParentChildren->parentsOnly(),
                        fn($join) => $join
                            ->on(
                                'pco.product_id',
                                '=',
                                'cp.id'
                            )
                    )
                    ->on(
                        'pco.option_id',
                        '=',
                        'poptval.id'
                    )
            )
            ->groupByRaw("poptval.name");
    }
}

