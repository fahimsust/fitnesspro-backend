<?php

namespace Domain\Products\Actions\Product\Query;

use Domain\Products\Models\Product\Product;
use Domain\Products\QueryBuilders\ProductQuery;
use Domain\Products\Traits\BuildsPriceSelects;
use Domain\Products\ValueObjects\ProductQueryParameters;
use Domain\Sites\Models\Site;
use Illuminate\Database\Query\JoinClause;
use Support\Contracts\AbstractAction;

class BuildProductQuery extends AbstractAction
{
    use BuildsPriceSelects;

//    public $addto_fields, $addto, $filters=array(), $override_fields = false,
//	public $addto_joins=array(), $addto_left_joins=array(), $joins = array(), $left_joins = array(), $table = "products p";


    private \Illuminate\Database\Eloquent\Builder $query;
    private ?Site $site = null;

    public function __construct(
        public ProductQueryParameters $params,
    )
    {
        $this->site = $this->params->site;
        $this->customer = $this->params->customer;
    }

    public function execute(): ProductQuery
    {
        $this->query = Product::query()
            ->fromRaw('products p')
            ->useAliasDeletedAt();

        BuildDetailsIntoQuery::now(
            $this->query,
            $this->params,
            $this->customer,
        );

        BuildPricingIntoQuery::now(
            $this->query,
            $this->params,
            $this->customer,
        );

        $this->applyIfNoCustomerCriteria();
        $this->applyStatusCriteria();

        ApplyAccountTypeFilterToQuery::now(
            customer: $this->customer,
            params: $this->params,
            query: $this->query
        );

        ApplyFiltersToQuery::now(
            params: $this->params,
            query: $this->query
        );

        ApplySiteCriteriaToQuery::now(
            site: $this->site,
            params: $this->params,
            query: $this->query
        );

        if ($this->params->is_filter) {
            return $this->query;
        }

        $this->query->groupBy(
            ...$this->getGroupBy()
        );

        return $this->query;
    }

    protected function applyStatusCriteria(): void
    {
        if ($this->params->filter_status) {
            $this->query->whereRaw('p.status'
                . $this->params->filter_status_compare
                . $this->params->filter_status_value);
        }

        if ($this->params->filter_pricing_status) {
            $this->query->whereRaw('pp.status'
                . $this->params->filter_pricing_status_compare
                . $this->params->filter_pricing_status_value);
        }
    }

    protected function applyIfNoCustomerCriteria(): void
    {
        if (!$this->customer || !$this->customer->hasSiteDiscountLevel()) {
            $this->query->leftJoin(
                \DB::raw('products_rules_ordering orules'),
                fn(JoinClause $join) => $join
                    ->on('orules.id', '=', 'pp.ordering_rule_id')
                    ->whereRaw('pp.ordering_rule_id > 0')
                    ->whereRaw('orules.status = 1')
            );
        }
    }

    function joinRelated()
    {
        $this->query->join(
            \DB::raw('products_related r'),
            'r.related_id',
            '=',
            'p.id'
        );
    }

    protected function getGroupBy(): array
    {
        return ['p.id'];

//        if ($this->params->includeParentChildren->childrenOnly()) {
//            return ['p.id'];
//        }
//
//        return [
//            'p.id',
////            'cpp.product_id',
//        ];
    }
}

