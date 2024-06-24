<?php

namespace Domain\Products\Actions\Filter\Query;

use Domain\Products\Contracts\ApplyFilterToQueryAction;
use Domain\Products\Models\Filters\Filter;
use Domain\Products\Models\Filters\FilterPricing;
use Domain\Products\QueryBuilders\ProductQuery;
use Domain\Products\Traits\BuildsPriceSelects;
use Domain\Products\ValueObjects\ProductQueryParameters;
use Support\Contracts\AbstractAction;

class ApplyPriceFilterToQuery
    extends AbstractAction
    implements ApplyFilterToQueryAction
{
    use BuildsPriceSelects;

    public function __construct(
        private ProductQuery           $query,
        private ProductQueryParameters $params,
        private Filter                 $filter,
        private mixed                  $field,
    )
    {
    }

    public function execute(): void
    {
        if (!$this->params->includeParentChildren->parentsOnly()) {
            return;
        }

        $ranges = $this->filter
            ->loadMissingReturn('pricing')
            ->whereIn("id", $this->field->compare);

        if ($ranges->isEmpty()) {
            return;
        }

        $this->query->where(
            fn($query) => $ranges->each(
                fn(FilterPricing $range) => $this->applyPriceRange(
                    $query,
                    $range
                )
            )
        );
    }

    protected function applyPriceRange(
        ProductQuery  $query,
        FilterPricing $range
    ): void
    {
        $query->orWhere(
            fn($query) => $query
                ->when(
                    $range->price_min > 0,
                    fn($query) => $query->where(
                        fn($query) => $query
                            ->whereRaw($this->priceSelect(child: true) . ">=" . $range->price_min)
                            ->orWhereRaw($this->priceSelect() . ">=" . $range->price_min)
                    )
                )
                ->when(
                    $range->price_max > 0,
                    fn($query) => $query->where(
                        fn($query) => $query
                            ->whereRaw($this->priceSelect(child: true) . "<=" . $range->price_max)
                            ->orWhereRaw($this->priceSelect() . "<=" . $range->price_max)
                    )
                )
        );
    }
}
