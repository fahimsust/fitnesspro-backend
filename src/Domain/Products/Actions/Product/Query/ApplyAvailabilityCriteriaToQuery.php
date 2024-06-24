<?php

namespace Domain\Products\Actions\Product\Query;

use Domain\Products\Contracts\ApplyFilterToQueryAction;
use Domain\Products\Enums\FilterTypes;
use Domain\Products\Models\Filters\Filter;
use Domain\Products\QueryBuilders\ProductQuery;
use Domain\Products\ValueObjects\FilterField;
use Domain\Products\ValueObjects\FilterWithFields;
use Domain\Products\ValueObjects\ProductQueryParameters;
use Illuminate\Database\Query\JoinClause;
use Support\Contracts\AbstractAction;

class ApplyAvailabilityCriteriaToQuery
    extends AbstractAction
    implements ApplyFilterToQueryAction
{
    public function __construct(
        private ProductQuery           $query,
        private ProductQueryParameters $params,
    )
    {
    }

    public function execute(): void
    {
        if ($this->params->ignore_availability) {
            return;
        }

        $this->query
            ->addSelect(
                collect([
                    'pa.name as availability_name',
                    'IF(pac.id=2, pa.name, pac.name) as calculated_availability_name',
                    'IF(pac.id=2, pa.id, pac.id) as calculated_availability_id'
                ])
                    ->map(fn($field) => \DB::raw($field))
                    ->toArray()
            )
            ->join(
                \DB::raw('products_availability pa'),
                fn(JoinClause $join) => $join
                    ->on('pa.id', '=', 'p.default_outofstockstatus_id')
            )
            ->leftJoin(
                \DB::raw('products_availability pac'),
                fn(JoinClause $join) => $join
                    ->whereRaw('p.inventoried = 1')
                    ->whereRaw('pac.auto_adjust = 1')
                    ->where(
                        fn($query) => $query
                            ->whereRaw('p.combined_stock_qty >= pac.qty_min')
                            ->orWhereRaw('pac.qty_min IS NULL')
                    )
                    ->where(
                        fn($query) => $query
                            ->whereRaw('p.combined_stock_qty <= pac.qty_max')
                            ->orWhereRaw('pac.qty_max IS NULL')
                    )
            );
    }
}
