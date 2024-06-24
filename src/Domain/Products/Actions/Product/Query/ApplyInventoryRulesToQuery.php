<?php

namespace Domain\Products\Actions\Product\Query;

use Domain\Products\QueryBuilders\ProductQuery;
use Domain\Products\ValueObjects\ProductQueryParameters;
use Domain\Sites\Models\InventoryRule;
use Domain\Sites\Models\Site;
use Support\Contracts\AbstractAction;

class ApplyInventoryRulesToQuery extends AbstractAction
{
    public function __construct(
        public Site                   $site,
        public ProductQueryParameters $params,
        public ProductQuery           $query,
    )
    {
    }

    public function execute(): void
    {
        if (
            $this->params->ignore_inventory_rules
            || !$this->site
            || $this->site->inventoryRules->isEmpty()
        ) {
            return;
        }

        $this->site->inventoryRules->each(
            fn(InventoryRule $rule) => ApplyInventoryRuleToQuery::now(
                $rule,
                $this->params,
                $this->query,
            )
        );
    }
}
