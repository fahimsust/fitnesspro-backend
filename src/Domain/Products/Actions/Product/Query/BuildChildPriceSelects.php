<?php

namespace Domain\Products\Actions\Product\Query;

use Domain\Accounts\Models\Account;
use Domain\Products\Enums\IncludeParentChildrenOptions;
use Support\Contracts\AbstractAction;

class BuildChildPriceSelects extends AbstractAction
{
    public function __construct(
        public IncludeParentChildrenOptions $includeParentChildren,
        public ?Account                     $customer,
    )
    {
    }

    public function execute(): array
    {
        if ($this->includeParentChildren->includesChildren()) {
            return [];
        }

        return collect([
            'IF(cpp.product_id IS NOT NULL,
                        MIN(' . $this->priceIfQuery(
                bypass_discount: true,
                child: true
            ) . '),
                        NULL
                    ) as beforediscount_child_min',
            'IF(cpp.product_id IS NOT NULL,
                        MAX(' . $this->priceIfQuery(
                bypass_discount: true,
                child: true
            ) . '),
                        NULL
                    ) as beforediscount_child_max',
            'IF(cpp.product_id IS NOT NULL,
                        MAX(' . $this->priceIfQuery(
                bypass_discount: true,
                child: true,
                get_reg_price: true
            ) . '),
                        NULL
                    ) as beforediscount_child_max_reg',
            'IF(cpp.product_id IS NOT NULL,
                        MIN(' . $this->priceIfQuery(
                bypass_discount: true,
                child: true,
                get_reg_price: true
            ) . '),
                        NULL
                    ) as beforediscount_child_min_reg',
            'IF(cpp.product_id IS NOT NULL,
                        MIN(' . $this->priceIfQuery(
                bypass_discount: true,
                child: true,
                get_sale_price: true
            ) . '),
                        NULL
                    ) as beforediscount_child_min_sale',
            'IF(cpp.product_id IS NOT NULL,
                        MAX(' . $this->priceIfQuery(
                bypass_discount: true,
                child: true,
                get_sale_price: true
            ) . '),
                        NULL
                    ) as beforediscount_child_max_sale',
            'IF(cpp.product_id IS NOT NULL,
                        MAX(' . $this->priceIfQuery(
                bypass_discount: true,
                child: true,
                is_onsale: true
            ) . '),
                        NULL
                    ) as beforediscount_child_onsale',
            'IF(cpp.product_id IS NOT NULL,
                        MIN(' . $this->priceIfQuery(child: true) . '),
                        NULL
                    ) as child_min',
            'IF(cpp.product_id IS NOT NULL,
                        MAX(' . $this->priceIfQuery(child: true) . '),
                        NULL
                    ) as child_max',
            'IF(cpp.product_id IS NOT NULL,
                        MAX(' . $this->priceIfQuery(
                child: true,
                get_reg_price: true
            ) . '),
                        NULL
                    ) as child_max_reg',
            'IF(cpp.product_id IS NOT NULL,
                        MIN(' . $this->priceIfQuery(
                child: true,
                get_reg_price: true
            ) . '),
                        NULL
                    ) as child_min_reg',
            'IF(cpp.product_id IS NOT NULL,
                        MIN(' . $this->priceIfQuery(
                child: true,
                get_sale_price: true
            ) . '),
                        NULL
                    ) as child_min_sale',
            'IF(cpp.product_id IS NOT NULL,
                        MAX(' . $this->priceIfQuery(
                child: true,
                get_sale_price: true
            ) . '),
                        NULL
                    ) as child_max_sale',
            'IF(cpp.product_id IS NOT NULL,
                        MAX(' . $this->priceIfQuery(
                child: true,
                is_onsale: true
            ) . '),
                        NULL
                    ) as child_onsale'
        ])
            ->map(fn($select) => \DB::raw($select))
            ->toArray();
    }

    private function priceIfQuery(...$args): string
    {
        return BuildPriceSelect::now($this->customer, ...$args);
    }
}
