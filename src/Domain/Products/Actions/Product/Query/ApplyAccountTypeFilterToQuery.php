<?php

namespace Domain\Products\Actions\Product\Query;

use Domain\Accounts\Models\Account;
use Domain\Products\QueryBuilders\ProductQuery;
use Domain\Products\ValueObjects\ProductQueryParameters;
use Illuminate\Database\Query\JoinClause;
use Support\Contracts\AbstractAction;

class ApplyAccountTypeFilterToQuery extends AbstractAction
{
    public function __construct(
        public ?Account               $customer,
        public ProductQueryParameters $params,
        public ProductQuery           $query,
    )
    {
    }

    public function execute(): void
    {
        if (!$this->customer || !$this->customer->accountTypeFilter()) {
            return;
        }

        $this->query->leftJoin(
            'accounts-types_products accttypeprods',
            fn(JoinClause $join) => $join
                ->on('accttypeprods.product_id', '=', 'p.id')
                ->where('accttypeprods.type_id', '=', $this->customer->accountType->id)
        );

        if ($this->params->includeParentChildren->parentsOnly()) {
            $this->query->leftJoin(
                'accounts-types_products caccttypeprods',
                fn(JoinClause $join) => $join
                    ->on('caccttypeprods.product_id', '=', 'cp.id')
                    ->where('caccttypeprods.type_id', '=', $this->customer->accountType->id)
            );
        }

        match ($this->customer->accountType->filter_products) {
            1 => $this->filterProductsAssignedToAccountType(),
            2 => $this->filterProductsNotAssignedToAccountType(),
        };
    }

    protected function filterProductsAssignedToAccountType()
    {
        $this->query->whereRaw("accttypeprods . type_id IS NOT NULL");

        if ($this->params->includeParentChildren->parentsOnly()) {
            $this->query->whereRaw("cp . id IS NULL or caccttypeprods . type_id IS NOT NULL");
        }
    }

    protected function filterProductsNotAssignedToAccountType()
    {
        $this->query->whereRaw("accttypeprods . type_id IS NULL");

        if ($this->params->includeParentChildren->parentsOnly()) {
            $this->query->whereRaw("caccttypeprods . type_id IS NULL");
        }
    }
}
