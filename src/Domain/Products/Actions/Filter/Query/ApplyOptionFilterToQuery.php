<?php

namespace Domain\Products\Actions\Filter\Query;

use Domain\Products\Contracts\ApplyFilterToQueryAction;
use Domain\Products\Models\Filters\Filter;
use Domain\Products\QueryBuilders\ProductQuery;
use Domain\Products\ValueObjects\ProductQueryParameters;
use Illuminate\Database\Query\JoinClause;
use Support\Contracts\AbstractAction;

class ApplyOptionFilterToQuery
    extends AbstractAction
    implements ApplyFilterToQueryAction
{
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
        $compares = $this->field->compare;

        if (!is_array($this->field->compare)) {
            $compares = array($this->field->compare);
        }

        if (!count($compares)) {
            return;
        }

        if ($this->params->includeParentChildren->childrenOnly()) {
            $joinAction = "leftJoin";
            $onField = "p.id";
        } else {
            $joinAction = $this->params->includeParentChildren->parentsOnly()
            && $this->filter->override_parent == 1
                ? "join"
                : "leftJoin";
            $onField = "cp.id";
        }

        $this->query->{$joinAction}(
            \DB::raw('products_children_options pco_filter'
                . $this->filter->id),
            fn(JoinClause $join) => $join->on(
                'pco_filter' . $this->filter->id . '.product_id',
                '=',
                $onField
            )
        );

        $compares = explode(
            ",",
            implode(",", $compares)
        );

        $this->query->whereIn(
            "pco_filter{$this->filter->id}.option_id",
            $compares
        );
    }
}
