<?php

namespace Domain\Products\Actions\Filter\Query;

use Domain\Products\Contracts\ApplyFilterToQueryAction;
use Domain\Products\Enums\FilterTypes;
use Domain\Products\Models\Filters\Filter;
use Domain\Products\QueryBuilders\ProductQuery;
use Domain\Products\ValueObjects\FilterField;
use Domain\Products\ValueObjects\FilterWithFields;
use Domain\Products\ValueObjects\ProductQueryParameters;
use Illuminate\Database\Query\JoinClause;
use Support\Contracts\AbstractAction;

class ApplyAvailabilityFilterToQuery
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
        if (
            $this->params->ignore_availability
            || !$this->isFilteringAvailability()
        ) {
            return;
        }

        $this->query
            ->leftJoin(
                \DB::raw('products_availability childpa'),
                fn(JoinClause $join) => $join
                    ->whereRaw('p.has_children = 1')
                    ->on('childpa.id', '=', 'cp.default_outofstockstatus_id')
            )
            ->leftJoin(
                \DB::raw('products_availability childpac'),
                fn(JoinClause $join) => $join
                    ->whereRaw('p.has_children = 1')
                    ->whereRaw('cp.inventoried = 1')
                    ->whereRaw('childpac.auto_adjust = 1')
                    ->where(
                        fn($query) => $query
                            ->whereRaw('cp.combined_stock_qty >= childpac.qty_min')
                            ->orWhereRaw('childpac.qty_min IS NULL')
                    )
                    ->where(
                        fn($query) => $query
                            ->whereRaw('cp.combined_stock_qty <= childpac.qty_max')
                            ->orWhereRaw('childpac.qty_max IS NULL')
                    )
            );

        $this->params->filters
            ->each(
                fn(FilterWithFields $filterWithFields) => $filterWithFields->fields
                    ->each(
                        fn(FilterField $field) => $this
                            ->applyFilterField(
                                $filterWithFields->filter,
                                $field
                            )
                    )
            );
    }

    protected function applyFilterField(
        Filter      $filter,
        FilterField $field
    ): void
    {
        if (
            !$field->compare
            || !count($field->compare)
            || $field->compare == ""
        ) {
            return;
        }

        $availabilityIds = $this->availabilityIds($filter, $field);

        if (!count($availabilityIds)) {
            return;
        }

        if ($this->params->includeParentChildren->parentsOnly()) {
            $this->query->where(
                fn($query) => $query
                    ->whereIn(
                        \DB::raw("IF(pac.id = 2, pa.id, pac.id)"),
                        $availabilityIds
                    )
                    ->orWhereIn(
                        \DB::raw("IF(childpac.id = 2, childpa.id, childpac.id)"),
                        $availabilityIds
                    )
            );

            return;
        }

        $this->query->whereIn(
            \DB::raw("IF(pac.id = 2, pa.id, pac.id)"),
            $availabilityIds
        );
    }

    protected function isFilteringAvailability(): bool
    {
        if (
            $this->params->filters->isEmpty()
            || !$this->params->includeParentChildren->parentsOnly()
        ) {
            return false;
        }

        return $this->params->filters
            ->contains(
                fn(FilterWithFields $filterWithFields) => $filterWithFields
                        ->filter->type == FilterTypes::Availability
                    && $filterWithFields->fields->contains(
                        fn(FilterField $field) => $field->compare
                            && (count($field->compare) > 0 || $field->compare != "")
                            && $this->availabilityIds($filterWithFields->filter, $field)
                    )
            );
    }

    protected function availabilityIds(
        Filter      $filter,
        FilterField $field
    ): array
    {
        $avails = [];
        $compares = $field->compare;

        if (!is_array($field->compare)) {
            $compares = [$field->compare];
        }

        $filter->loadMissing('filterAvailabilities');

        foreach ($compares as $c) {
            $avail = $filter->filterAvailabilities->find($c);

            if (!$avail) {
                continue;
            }

            $avails = array_merge(
                $avails,
                explode("|", $avail->avail_ids)
            );
        }

        return $avails;
    }
}
