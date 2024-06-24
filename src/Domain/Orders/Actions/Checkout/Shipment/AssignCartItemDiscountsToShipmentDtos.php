<?php

namespace Domain\Orders\Actions\Checkout\Shipment;

use Domain\Orders\Collections\CheckoutShipmentDtosCollection;
use Domain\Orders\Dtos\AssignedDiscountAdvantageDto;
use Domain\Orders\Dtos\CheckoutItemDto;
use Domain\Orders\Dtos\CheckoutPackageDto;
use Domain\Orders\Dtos\CheckoutShipmentDto;
use Domain\Orders\Models\Carts\CartItems\CartItemDiscountAdvantage;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;

class AssignCartItemDiscountsToShipmentDtos extends AbstractAction
{

    public function __construct(
        public CheckoutShipmentDtosCollection $shipments,
        public Collection                     $assignedAdvantages = new Collection(),
    )
    {
    }

    public function execute(): CheckoutShipmentDtosCollection
    {
        return $this->shipments
            ->each(
                fn(CheckoutShipmentDto $shipment) => $shipment->packages->each(
                    fn(CheckoutPackageDto $package) => $package->items->each(
                        fn(CheckoutItemDto $item) => $this->assignItemDiscountsToPackage(...)
                    )
                )
            );
    }

    protected function assignItemDiscountsToPackage(CheckoutItemDto $item): void
    {
        $item->discountAdvantages->each(
            fn(CartItemDiscountAdvantage $advantage) => $this->assignAdvantage($item, $advantage)
        );

    }

    protected function assignAdvantage(
        CheckoutItemDto           $item,
        CartItemDiscountAdvantage $advantage
    ): void
    {
        $availableQty = $this->assignedAdvantages->has($advantage->id)
            ? $advantage->qty - $this->assignedAdvantages->get($advantage->id)->qty
            : $advantage->qty;

        if ($availableQty <= 0) {
            return;
        }

        $qty = $availableQty >= $item->orderQty
            ? $item->orderQty
            : $availableQty;

        $applying = AssignedDiscountAdvantageDto::fromCartItemAdvantage(
            $advantage,
            $qty
        );

        $item->appliedAdvantages->push($applying);
        $this->assignedAdvantages[$advantage->id] = $applying;
    }
}
