<?php

namespace Domain\Products\Actions\Product\Query;

use Domain\Accounts\Models\Account;
use Domain\Products\QueryBuilders\ProductQuery;
use Domain\Products\Traits\BuildsPriceSelects;
use Domain\Products\ValueObjects\ProductQueryParameters;
use Support\Contracts\AbstractAction;

class BuildPricingIntoQuery extends AbstractAction
{
    use BuildsPriceSelects;

    public bool $discounted = false;
    public array $select = [];

    public function __construct(
        public ProductQuery           $query,
        public ProductQueryParameters $params,
        ?Account                      $customer = null
    )
    {
        $this->customer = $customer;
    }

    public function execute(): void
    {
        $this->query->join(
            \DB::raw('products_pricing pp'),
            'pp.product_id',
            '=',
            'p.id'
        );

        $this->buildPricingWithCustomer();

        if ($this->discounted) {
            $this->query->addSelect(
                $this->priceSelect(
                    'beforediscount_price',
                    bypass_discount: true
                )
            );
        }

        $this->query
            ->addSelect(\DB::raw($this->priceSelect('price')))
            ->addSelect(
                BuildChildPriceSelects::now(
                    includeParentChildren: $this->params->includeParentChildren,
                    customer: $this->customer
                )
            );
    }

    protected function buildPricingWithCustomer(): void
    {
        $customerPricing = BuildCustomerPricingIntoQuery::run(
            query: $this->query,
            params: $this->params,
            customer: $this->customer
        );

        if ($customerPricing->customerHasDiscountPricing()) {
            $this->discounted = true;

            return;
        }

        $this->query->addSelect([
            \DB::raw('IF(pp.onsale != 1 AND pp.price_reg=0 AND pp.price_sale > 0, pp.price_sale, pp.price_reg) as price_reg'),
            'pp.price_sale',
            'pp.onsale',
            'pp.pricing_rule_id'
        ]);
    }
}
