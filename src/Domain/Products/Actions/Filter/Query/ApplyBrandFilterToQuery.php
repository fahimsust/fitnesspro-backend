<?php

namespace Domain\Products\Actions\Filter\Query;

use Domain\Products\Contracts\ApplyFilterToQueryAction;
use Domain\Products\QueryBuilders\ProductQuery;
use Support\Contracts\AbstractAction;

class ApplyBrandFilterToQuery
    extends AbstractAction
    implements ApplyFilterToQueryAction
{
    public function __construct(
        private ProductQuery $query,
        private mixed        $field,
    )
    {
    }

    public function execute(): void
    {
        $compares = $this->field->compare;

        if (!is_array($this->field->compare)) {
            $compares = array($this->field->compare);
        }

        if (count($compares) > 0) {
            $this->query->whereIn('b.id', $compares);
        }
    }
}
