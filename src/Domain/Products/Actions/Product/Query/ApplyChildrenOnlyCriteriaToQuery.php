<?php

namespace Domain\Products\Actions\Product\Query;

use Domain\Products\QueryBuilders\ProductQuery;
use Domain\Products\Traits\BuildsPriceSelects;
use Domain\Products\Traits\JoinsProductSettingsTable;
use Domain\Products\ValueObjects\ProductQueryParameters;
use Illuminate\Database\Query\JoinClause;
use Support\Contracts\AbstractAction;

class ApplyChildrenOnlyCriteriaToQuery extends AbstractAction
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
        if (!$this->params->includeParentChildren->childrenOnly()) {
            return;
        }

        $this->query->whereRaw('`p`.`parent_product` > 0');

        $this->includeParent();
        $this->includeDetails();

        $this->settingsJoin(
            query: $this->query,
            params: $this->params,
        );
    }

    protected function includeParent(): void
    {
        if (!$this->params->include_parent) {
            return;
        }

        $this->query
            ->addSelect(
                collect([
                    'par.title as parent_title',
                    'par.category_img_id as parent_category_img_id',
                    'par.status as parent_status',
                    'par.product_no as parent_product_no',
                    'ipar.filename as parent_filename',
                    'IF(par.id IS NOT NULL, par.url_name, p.url_name) as url_name',
                    'p.url_name as child_url_name, par.url_name as parent_url_name'
                ])
                    ->map(fn($field) => \DB::raw($field))
                    ->toArray()
            )
            ->join(
                \DB::raw('products par'),
                'par.id',
                '=',
                'p.parent_product'
            );

        if ($this->params->include_images) {
            $this->query->leftJoin(
                \DB::raw('images ipar'),
                'ipar.id',
                '=',
                'par.category_img_id'
            );
        }
    }

    protected function includeDetails(): void
    {
        if (!$this->params->include_details) {
            return;
        }

        $this->query->leftJoin(
            \DB::raw('products_details pd'),
            fn(JoinClause $join) => $join
                ->on(
                    'pd.product_id',
                    '=',
                    'p.parent_product'
                )
        );
    }
}
