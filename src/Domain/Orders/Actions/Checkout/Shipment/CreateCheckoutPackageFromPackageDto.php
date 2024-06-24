<?php

namespace Domain\Orders\Actions\Checkout\Shipment;

use Domain\Orders\Dtos\CheckoutItemDto;
use Domain\Orders\Dtos\CheckoutPackageDto;
use Domain\Orders\Models\Checkout\CheckoutPackage;
use Domain\Orders\Models\Checkout\CheckoutShipment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;

class CreateCheckoutPackageFromPackageDto extends AbstractAction
{
    private Collection $items;

    public function __construct(
        public CheckoutShipment   $shipment,
        public CheckoutPackageDto $packageDto,
    )
    {
        $this->items = new Collection();
    }

    public function execute(): CheckoutPackage
    {
        $package = $this->createModel();

        $this->packageDto->checkoutPackage = $package;

        $this->packageDto->items->each(
            fn(CheckoutItemDto $itemDto) => $this->items->push(
                CreateCheckoutItemFromItemDto::now(
                    $package,
                    $itemDto,
                )
            )
        );

        return $package->setRelation('items', $this->items);
    }

    private function createModel(): CheckoutPackage|Model
    {
        return CheckoutPackage::create(
                $this->packageDto->toPackageModel()
            );
    }
}
