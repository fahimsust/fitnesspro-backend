<?php

namespace Domain\Products\Actions\Product\Query;

use Domain\Products\QueryBuilders\ProductQuery;
use Domain\Products\Traits\BuildsPriceSelects;
use Domain\Products\Traits\JoinsProductSettingsTable;
use Domain\Products\ValueObjects\ProductQueryParameters;
use Domain\Sites\Models\Site;
use Support\Contracts\AbstractAction;

class ApplySiteCriteriaToQuery extends AbstractAction
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
        if (!$this->site) {
            return;
        }

        $this->query->where('pp.site_id', $this->site->id);

        ApplyInventoryRulesToQuery::now(
            site: $this->site,
            params: $this->params,
            query: $this->query
        );
    }
}
