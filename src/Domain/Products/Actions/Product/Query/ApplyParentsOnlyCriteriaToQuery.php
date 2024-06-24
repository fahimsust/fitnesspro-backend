<?php

namespace Domain\Products\Actions\Product\Query;

use Domain\Products\QueryBuilders\ProductQuery;
use Domain\Products\Traits\BuildsPriceSelects;
use Domain\Products\Traits\JoinsProductSettingsTable;
use Domain\Products\ValueObjects\FilterField;
use Domain\Products\ValueObjects\FilterWithFields;
use Domain\Products\ValueObjects\ProductQueryParameters;
use Domain\Sites\Models\Site;
use Illuminate\Database\Query\JoinClause;
use Support\Contracts\AbstractAction;

class ApplyParentsOnlyCriteriaToQuery extends AbstractAction
{
    use BuildsPriceSelects,
        JoinsProductSettingsTable;

    public function __construct(
        public ?Site                  $site,
        public ProductQueryParameters $params,
        public ProductQuery           $query,
    )
    {
    }

    public function execute(): void
    {
        if (!$this->params->includeParentChildren->parentsOnly()) {
            return;
        }

        $this->query
            ->whereRaw('(p.parent_product is null OR p.parent_product = 0)')
            ->leftJoin(
                \DB::raw('products cp'),
                fn(JoinClause $join) => $join
                    ->on('cp.parent_product', '=', 'p.id')
                    ->whereRaw('p.has_children = 1')

            )
            ->leftJoin(
                \DB::raw('products_pricing cpp'),
                fn(JoinClause $join) => $join
                    ->on('cpp.product_id', '=', 'cp.id')
                    ->whereRaw('p.has_children = 1')
                    ->whereRaw('cp.id > 0')
                    ->when(
                        $this->params->filter_pricing_status,
                        fn(JoinClause $join) => $join->where(
                            'cpp.status',
                            $this->params->filter_pricing_status_compare,
                            $this->params->filter_pricing_status_value
                        )
                    )
                    ->when(
                        $this->site != null,
                        fn(JoinClause $join) => $join
                            ->where('cpp.site_id', '=', $this->site->id)
                    )
            );

        if ($this->params->filter_status) {
            $this->query->where(
                fn($query) => $query
                    ->whereRaw('cp.status'
                        . $this->params->filter_status_compare
                        . $this->params->filter_status_value)
                    ->orWhereRaw('p.has_children = 0')
            );
        }

        $this->joinDetailsTables();
    }

    protected function joinDetailsTables()
    {
        if ($this->params->pricing_only) {
            return;
        }

        if ($this->params->include_details) {
            $this->query->join(
                \DB::raw('products_details pd'),
                'pd.product_id',
                '=',
                'p.id'
            );
        }

        if ($filter_id = $this->filterOverrideParent()) {
            $this->query
                ->addSelect([
                    \DB::raw('ci.filename as child_filename'),
                    \DB::raw('pco_filter' . $filter_id . '.option_id as override_parent_option_id')
                ])
                ->leftJoin(
                    \DB::raw('images ci'),
                    fn(JoinClause $join) => $join
                        ->on('ci.id', '=', 'cp.category_img_id')
                        ->whereRaw('cp.category_img_id > 0')
                );
        }

        $this->settingsJoin(
            query: $this->query,
            params: $this->params,
        );
    }

    protected function filterOverrideParent()
    {
        if ($this->params->filters->isEmpty()) {
            return false;
        }

        $this->params->filters
            ->each(
                fn(FilterWithFields $filterWithFields) => $filterWithFields
                    ->fields
                    ->each(
                        function (FilterField $field) use ($filterWithFields) {
                            if (
                                $filterWithFields->filter->type != 5
                                || $filterWithFields->filter->override_parent != 1
                                || empty($field->compare)
                            ) {
                                return false;
                            }

                            $compares = $field->compare;

                            if (!is_array($field->compare)) {
                                $compares = array($field->compare);
                            }

                            if (count($compares) > 0) {
                                return $filterWithFields->filter->id;
                            }
                        }
                    )
            );
    }
}
