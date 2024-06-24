<?php

namespace Domain\Products\Actions\Filter\Query;

use Domain\Products\Contracts\ApplyFilterToQueryAction;
use Domain\Products\QueryBuilders\ProductQuery;
use Support\Contracts\AbstractAction;

class ApplyAttributeFilterToQuery
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
        $this->query->whereJsonContains(
            'pd.attributes', $this->field->compare,
        );
    }
}
