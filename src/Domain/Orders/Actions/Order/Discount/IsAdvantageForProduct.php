<?php

namespace Domain\Orders\Actions\Order\Discount;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Support\Contracts\AbstractAction;

class IsAdvantageForProduct extends AbstractAction
{
    public function __construct(
        public DiscountAdvantage $advantage,
        public int               $productId
    ) {
    }

    public function execute(): bool
    {
        return $this->advantage->type()->isProductSpecific()
            && $this->advantage->products->isNotEmpty()
            && $this->advantageIncludesProduct();
    }

    protected function advantageIncludesProduct(): bool
    {
        return $this->advantage->products
            ->pluck('product_id')
            ->contains($this->productId);
    }
}
