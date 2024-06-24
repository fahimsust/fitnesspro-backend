<?php

namespace Domain\Orders\Actions\Checkout\Shipment;

use Domain\Orders\Dtos\AssignedDiscountAdvantageDto;
use Domain\Orders\Dtos\CheckoutItemDto;
use Domain\Orders\Models\Checkout\CheckoutItem;
use Domain\Orders\Models\Checkout\CheckoutPackage;
use Illuminate\Database\Eloquent\Model;
use Support\Contracts\AbstractAction;

class CreateCheckoutItemFromItemDto extends AbstractAction
{
    public function __construct(
        public CheckoutPackage $package,
        public CheckoutItemDto $checkoutItemDto,
    )
    {
    }

    public function execute(): CheckoutItem
    {
        $item = $this->createModel();

        $this->checkoutItemDto->checkoutItem = $item;

        $item->discounts()
            ->createMany(
                $this->checkoutItemDto
                    ->appliedAdvantages
                    ->map(
                        fn(AssignedDiscountAdvantageDto $dto) => $dto->toItemDiscountModel()
                    )
            );

        return $item;
    }

    private function createModel(): CheckoutItem|Model
    {
        return $this->package->items()->create(
            $this->checkoutItemDto->toCheckoutItem()
        );
    }
}
