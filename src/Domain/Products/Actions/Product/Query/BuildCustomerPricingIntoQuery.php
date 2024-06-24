<?php

namespace Domain\Products\Actions\Product\Query;

use Domain\Accounts\Models\Account;
use Domain\Products\QueryBuilders\ProductQuery;
use Domain\Products\Traits\BuildsPriceSelects;
use Domain\Products\ValueObjects\ProductQueryParameters;
use Illuminate\Database\Query\JoinClause;
use Support\Contracts\AbstractAction;

class BuildCustomerPricingIntoQuery extends AbstractAction
{
    use BuildsPriceSelects;

    public function __construct(
        public ProductQuery           $query,
        public ProductQueryParameters $params,
        ?Account                      $customer = null
    )
    {
    }

    public function execute(): static
    {
        if (!$this->customerHasDiscountPricing()) {
            return $this;
        }

        match (true) {
            $this->customer->hasSiteDiscountLevel() => $this->buildForSiteDiscountLevel(),
            $this->customer->hasPercentageDiscountLevel() => $this->buildPercentageDiscountLevel(),
        };

        return $this;
    }

    public function customerHasDiscountPricing(): bool
    {
        if (!$this->customer) {
            return false;
        }

        return $this->customer->hasSiteDiscountLevel()
            || $this->customer->hasPercentageDiscountLevel();
    }

    protected function buildForSiteDiscountLevel(): void
    {
        $this->query
            ->addSelect(
                collect(
                    match ($this->customer->discountLevel->apply_to) {
                        //all products
                        "0" => [
                            'IF(altpp.price_reg IS NOT NULL, altpp.price_reg, null) as beforediscount_price_reg, IF(altpp.price_reg IS NOT NULL, altpp.price_reg, pp.price_reg) as price_reg',
                            'IF(altpp.price_reg IS NOT NULL, altpp.price_sale, null) as beforediscount_price_sale, altpp.price_sale, pp.price_sale) as price_sale',
                            'IF(altpp.price_reg IS NOT NULL, altpp.onsale, null) as beforediscount_onsale, altpp.onsale, pp.onsale) as onsale',
                            'IF(altpp.price_reg IS NOT NULL, altpp.pricing_rule_id, pp.pricing_rule_id) as pricing_rule_id'
                        ],

                        //assigned to level
                        "1" => [
                            'IF(dlp.product_id IS NOT NULL && altpp.price_reg IS NOT NULL, altpp.price_reg, null) as beforediscount_price_reg, IF(dlp.product_id IS NOT NULL && altpp.price_reg IS NOT NULL, altpp.price_reg, pp.price_reg) as price_reg',
                            'IF(dlp.product_id IS NOT NULL && altpp.price_reg IS NOT NULL, altpp.price_sale, null) as beforediscount_price_sale, IF(dlp.product_id IS NOT NULL && altpp.price_reg IS NOT NULL, altpp.price_sale, pp.price_sale) as price_sale',
                            'IF(dlp.product_id IS NOT NULL && altpp.price_reg IS NOT NULL, altpp.onsale, null) as beforediscount_onsale, IF(dlp.product_id IS NOT NULL && altpp.price_reg IS NOT NULL, altpp.onsale, pp.onsale) as onsale',
                            'IF(dlp.product_id IS NOT NULL && altpp.price_reg IS NOT NULL, altpp.pricing_rule_id, pp.pricing_rule_id) as pricing_rule_id'
                        ],

                        //not assigned to level
                        "2" => [
                            'IF(dlp.product_id IS NULL && altpp.price_reg IS NOT NULL, altpp.price_reg, null) as beforediscount_price_reg, IF(dlp.product_id IS NULL && altpp.price_reg IS NOT NULL, altpp.price_reg, pp.price_reg) as price_reg',
                            'IF(dlp.product_id IS NULL && altpp.price_reg IS NOT NULL, altpp.price_sale, null) as beforediscount_price_sale, IF(dlp.product_id IS NULL && altpp.price_reg IS NOT NULL, altpp.price_sale, pp.price_sale) as price_sale',
                            'IF(dlp.product_id IS NULL && altpp.price_reg IS NOT NULL, altpp.onsale, null) as beforediscount_onsale, IF(dlp.product_id IS NULL && altpp.price_reg IS NOT NULL, altpp.onsale, pp.onsale) as onsale',
                            'IF(dlp.product_id IS NULL && altpp.price_reg IS NOT NULL, altpp.pricing_rule_id, pp.pricing_rule_id) as pricing_rule_id'
                        ],
                    }
                )
                    ->map(fn($select) => \DB::raw($select))
                    ->toArray()
            )
            ->leftJoin(
                \DB::raw('products_pricing altpp'),
                fn(JoinClause $join) => $join
                    ->on('altpp.product_id', '=', 'p.id')
                    ->where(
                        'altpp.site_id',
                        '=',
                        $this->customer->discountLevel->action_sitepricing
                    )
            );

        if ($this->params->includeParentChildren->parentsOnly()) {
            $this->query->leftJoin(
                \DB::raw('products_pricing caltpp'),
                fn(JoinClause $join) => $join
                    ->on(
                        'caltpp.product_id',
                        '=',
                        'cp.id'
                    )
                    ->where(
                        'caltpp.site_id',
                        '=',
                        $this->customer->discountLevel->action_sitepricing
                    )
            );
        }

        if ($this->customer->discountLevel->apply_to > 0) {//assigned to level OR not assigned to level
            $this->discountLevelProductsJoin();

            if ($this->params->includeParentChildren->parentsOnly()) {
                $this->query->leftJoin(
                    \DB::raw('discounts-levels_products cdlp'),
                    fn(JoinClause $join) => $join
                        ->on(
                            'cdlp.product_id',
                            '=',
                            'cp.id'
                        )
                        ->where(
                            'cdlp.discount_level_id',
                            '=',
                            $this->customer->discountLevel->id
                        )
                );
            }
        }

        $this->query->leftJoin(
            \DB::raw('products_rules_ordering orules'),
            fn(JoinClause $join) => $join
                ->when(
                    $this->customer->discountLevel->apply_to == 0,
                    fn(JoinClause $join) => $join
                        ->on(
                            'orules.id',
                            '=',
                            'IF(altpp.price_reg IS NOT NULL, altpp.ordering_rule_id, pp.ordering_rule_id)'
                        )
                        ->whereRaw('IF(altpp.price_reg IS NOT NULL, altpp.ordering_rule_id, pp.ordering_rule_id) > 0'),
                )
                ->when(
                    $this->customer->discountLevel->apply_to == 1,
                    fn(JoinClause $join) => $join
                        ->on(
                            'orules.id',
                            '=',
                            'IF(dlp.product_id IS NOT NULL && altpp.price_reg IS NOT NULL, altpp.ordering_rule_id, pp.ordering_rule_id)'
                        )
                        ->whereRaw('IF(dlp.product_id IS NOT NULL && altpp.price_reg IS NOT NULL, altpp.ordering_rule_id, pp.ordering_rule_id) > 0'),
                )
                ->when(
                    $this->customer->discountLevel->apply_to == 2,
                    fn(JoinClause $join) => $join
                        ->on(
                            'orules.id',
                            '=',
                            'IF(dlp.product_id IS NULL && altpp.price_reg IS NOT NULL, altpp.ordering_rule_id, pp.ordering_rule_id)'
                        )
                        ->whereRaw('IF(dlp.product_id IS NULL && altpp.price_reg IS NOT NULL, altpp.ordering_rule_id, pp.ordering_rule_id) > 0'),
                )
                ->whereRaw('orules.status = 1')
        );
    }

    protected function buildPercentageDiscountLevel(): void
    {
        $perc = $this->customer->discountLevel->action_percentage / 100;

        $this->query->addSelect(
            collect(
                match ($this->customer->discountLevel->apply_to) {
                    "0" => [
                        'pp.price_reg as beforediscount_price_reg',
                        'round(pp.price_reg - (pp.price_reg * ' . $perc . ') , 2) as price_reg',
                        'pp.price_reg as beforediscount_price_sale',
                        'round(pp.price_sale - (pp.price_sale * ' . $perc . '), 2) as price_sale',
                        'pp.onsale', 'pp.pricing_rule_id'
                    ],
                    "1" => [
                        'IF(dlp.product_id IS NOT NULL, pp.price_reg, null) as beforediscount_price_reg',
                        'IF(dlp.product_id IS NOT NULL, round(pp.price_reg - (pp.price_reg * ' . $perc . ') , 2), pp.price_reg) as price_reg',
                        'IF(dlp.product_id IS NOT NULL, pp.price_sale, null) as beforediscount_price_sale',
                        'IF(dlp.product_id IS NOT NULL, round(pp.price_sale - (pp.price_sale * ' . $perc . '), 2), pp.price_sale) as price_sale',
                        'pp.onsale',
                        'pp.pricing_rule_id'
                    ],
                    "2" => [
                        'IF(dlp.product_id IS NULL, pp.price_reg, NULL) as beforediscount_price_reg',
                        'IF(dlp.product_id IS NULL, round(pp.price_reg - (pp.price_reg * ' . $perc . ') , 2), pp.price_reg) as price_reg',
                        'IF(dlp.product_id IS NULL, pp.price_sale, NULL) as beforediscount_price_sale',
                        'IF(dlp.product_id IS NULL, round(pp.price_sale - (pp.price_sale * ' . $perc . '), 2), pp.price_sale) as price_sale',
                        'pp.onsale',
                        'pp.pricing_rule_id'
                    ]
                }
            )
                ->map(fn($select) => \DB::raw($select))
                ->toArray()
        );

        $this->discountLevelProductsJoin();

        if ($this->params->includeParentChildren->parentsOnly()) {
            $this->query->leftJoin(
                \DB::raw('discounts-levels_products cdlp'),
                fn(JoinClause $join) => $join
                    ->on('cdlp.product_id', '=', 'cp.id')
                    ->where(
                        'cdlp.discount_level_id',
                        '=',
                        $this->customer->discountLevel->id
                    )
            );
        }
    }

    protected function discountLevelProductsJoin(): void
    {
        $this->query->leftJoin(
            \DB::raw('discounts-levels_products dlp'),
            fn(JoinClause $join) => $join
                ->on('dlp.product_id', '=', 'p.id')
                ->where(
                    'dlp.discount_level_id',
                    '=',
                    $this->customer->discountLevel->id
                )
        );
    }
}
