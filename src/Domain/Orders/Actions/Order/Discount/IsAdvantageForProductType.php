<?php

namespace Domain\Orders\Actions\Order\Discount;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Support\Contracts\AbstractAction;

class IsAdvantageForProductType extends AbstractAction
{

    public function __construct(
        public DiscountAdvantage $advantage,
        public ?int               $typeId
    ) {
    }

    public function execute(): bool
    {
        return $this->advantage->type()->isProductTypeSpecific()
            && $this->advantage->productTypes->isNotEmpty()
            && $this->advantageIncludesProductType();
    }

    protected function advantageIncludesProductType(): bool
    {
        return $this->advantage->productTypes
            ->pluck('producttype_id')
            ->contains($this->typeId);
    }
}
