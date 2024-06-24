<?php

namespace Domain\Products\Actions\Product\Query;

use Domain\Products\QueryBuilders\ProductQuery;
use Domain\Products\Traits\BuildsPriceSelects;
use Domain\Products\Traits\JoinsProductSettingsTable;
use Domain\Products\ValueObjects\ProductQueryParameters;
use Illuminate\Database\Query\JoinClause;
use Support\Contracts\AbstractAction;

class ApplyParentsAndChildrenCriteriaToQuery extends AbstractAction
{
    use BuildsPriceSelects,
        JoinsProductSettingsTable;

    public function __construct(
        public ProductQueryParameters $params,
        public ProductQuery           $query,
    )
    {
    }

    public function execute(): void
    {
        if (!$this->params->includeParentChildren->both()) {
            return;
        }

        if ($this->params->include_details) {
            $this->query->leftJoin(
                \DB::raw('products_details pd'),
                fn(JoinClause $join) => $join->on(
                    'pd.product_id',
                    '=',
                    \DB::raw('IF(`p`.`parent_product` > 0, `p`.`parent_product`, `p`.`id`)')
                )
            );
        }

        if ($this->params->include_parent) {
            $this->query
                ->leftJoin(
                    \DB::raw('products par'),
                    'par.id',
                    '=',
                    'p.parent_product'
                )
                ->when(
                    $this->params->include_images,
                    fn(JoinClause $join) => $join->leftJoin(
                       \DB::raw('images ipar'),
                        'ipar.id',
                        '=',
                        'par.category_img_id'
                    )
                );
        }

        $this->settingsJoin(
            query: $this->query,
            params: $this->params,
        );
    }
}
