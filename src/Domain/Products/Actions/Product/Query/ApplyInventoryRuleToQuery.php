<?php

namespace Domain\Products\Actions\Product\Query;

use Domain\Products\ValueObjects\ProductQueryParameters;
use Domain\Sites\Models\InventoryRule;
use Illuminate\Database\Query\Builder;
use Support\Contracts\AbstractAction;

class ApplyInventoryRuleToQuery extends AbstractAction
{
    public function __construct(
        public InventoryRule          $rule,
        public ProductQueryParameters $params,
        public Builder                $query,
    )
    {
    }

    public function execute(): void
    {
        $this->applyMinStockCondition();
        $this->applyMaxStockCondition();
    }

    protected function applyMaxStockCondition(): void
    {
        if (!$this->rule->max_stock_qty) {
            return;
        }

        if ($this->params->includeParentChildren->parentsOnly()) {
            $this->query->where(
                fn($query) => $query
                    ->whereRaw('p.inventoried != 1')
                    ->orWhere(
                        fn($query) => $query
                            ->whereRaw('p.combined_stock_qty <= ' . $this->rule->max_stock_qty)
                            ->whereRaw('NOT EXISTS (SELECT NULL FROM products WHERE parent_product=p.id)')
                    )
                    ->orWhere(
                        fn($query) => $query
                            ->whereRaw('cp.id IS NOT NULL')
                            ->when(
                                $this->params->filter_status,
                                fn($query) => $query->whereRaw(
                                    'cp.status'
                                    . $this->params->filter_status_compare
                                    . $this->params->filter_status_value
                                )
                            )
                            ->when(
                                $this->params->filter_pricing_status,
                                fn($query) => $query->whereRaw(
                                    'cpp.status'
                                    . $this->params->filter_pricing_status_compare
                                    . $this->params->filter_pricing_status_value
                                )
                            )
                            ->whereRaw('cpp.site_id=' . $this->params->site->id)
                            ->whereRaw('cp.combined_stock_qty <= ' . $this->rule->max_stock_qty)
                    )
            );

            return;
        }

        $this->query->where(
            fn($query) => $query
                ->whereRaw('p.inventoried != 1')
                ->orWhereRaw('p.combined_stock_qty <= ' . $this->rule->max_stock_qty)
        );
    }

    protected function applyMinStockCondition(): void
    {
        if (!$this->rule->min_stock_qty) {
            return;
        }

        if ($this->params->includeParentChildren->parentsOnly()) {
            $this->query->where(
                fn($query) => $query
                    ->whereRaw('p.inventoried != 1')
                    ->orWhere(
                        fn($query) => $query
                            ->whereRaw('p.combined_stock_qty >= ' . $this->rule->min_stock_qty)
                            ->whereRaw('NOT EXISTS (SELECT NULL FROM products WHERE parent_product=p.id)')
                    )
                    ->orWhere(
                        fn($query) => $query
                            ->whereRaw('cp.id IS NOT NULL')
                            ->when(
                                $this->params->filter_status,
                                fn($query) => $query->whereRaw(
                                    'cp.status'
                                    . $this->params->filter_status_compare
                                    . $this->params->filter_status_value
                                )
                            )
                            ->when(
                                $this->params->filter_pricing_status,
                                fn($query) => $query->whereRaw(
                                    'cpp.status'
                                    . $this->params->filter_pricing_status_compare
                                    . $this->params->filter_pricing_status_value
                                )
                            )
                            ->whereRaw('cpp.site_id=' . $this->params->site->id)
                            ->whereRaw('cp.combined_stock_qty >= ' . $this->rule->min_stock_qty)
                    )
            );

            return;
        }

        $this->query->where(
            fn($query) => $query
                ->whereRaw('p.inventoried != 1')
                ->orWhereRaw('p.combined_stock_qty >= ' . $this->rule->min_stock_qty)
        );
    }
}
