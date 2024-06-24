<?php

namespace Domain\Products\Actions\Product\Query;

use Domain\Products\Models\Filters\Filter;
use Domain\Products\QueryBuilders\ProductQuery;
use Domain\Products\Traits\BuildsPriceSelects;
use Domain\Products\ValueObjects\FilterField;
use Domain\Products\ValueObjects\FilterWithFields;
use Domain\Products\ValueObjects\ProductQueryParameters;
use Support\Contracts\AbstractAction;

class ApplyFiltersToQuery extends AbstractAction
{
    use BuildsPriceSelects;

    public function __construct(
        public ProductQueryParameters $params,
        public ProductQuery           $query,
    )
    {
    }

    public function execute(): void
    {
        if ($this->params->is_filter) {
            return;
        }

        if ($this->params->filters->isEmpty()) {
            return;
        }

        $this->params->filters
            ->each(
                $this->applyFilterWithFields(...)
            );
    }

    protected function applyFilterWithFields(
        FilterWithFields $filterWithFields
    )
    {
        $filter = $filterWithFields->filter;

        $filterWithFields->fields
            ->each(
                fn(FilterField $filterField) => $this->applyFilterField(
                    $filter,
                    $filterField
                )
            );
    }

    protected function applyFilterField(
        Filter      $filter,
        FilterField $field
    )
    {
        if (!$field->compare || !count($field->compare) || $field->compare == "") {
            return;
        }

        $filter->type->applyToQueryAction(
            $this->query,
            $this->params,
            $filter,
            $field
        )
            ->execute();
    }
}
