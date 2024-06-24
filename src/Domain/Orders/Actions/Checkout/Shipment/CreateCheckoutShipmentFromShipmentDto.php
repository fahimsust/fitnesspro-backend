<?php

namespace Domain\Orders\Actions\Checkout\Shipment;

use Domain\Orders\Dtos\CheckoutPackageDto;
use Domain\Orders\Dtos\CheckoutShipmentDto;
use Domain\Orders\Models\Checkout\Checkout;
use Domain\Orders\Models\Checkout\CheckoutShipment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;

class CreateCheckoutShipmentFromShipmentDto extends AbstractAction
{
    private Collection $packages;

    public function __construct(
        public Checkout            $checkout,
        public CheckoutShipmentDto $shipmentDto,
    )
    {
        $this->packages = new Collection();
    }

    public function execute(): CheckoutShipment
    {
        \DB::beginTransaction();

        $shipment = $this->createModel();

        $this->shipmentDto->shipment = $shipment;
        $this->shipmentDto->id = $shipment->id;

        $this->shipmentDto->packages->each(
            fn(CheckoutPackageDto $packageDto) => $packageDto->checkoutShipment($shipment)
                && $this->packages->push(
                    CreateCheckoutPackageFromPackageDto::now(
                        $shipment,
                        $packageDto,
                    )
                )
        );

        \DB::commit();

        return $shipment->setRelation('packages', $this->packages);
    }

    private function createModel(): CheckoutShipment|Model
    {
        return $this->checkout->shipments()->create(
            $this->shipmentDto->toCheckoutShipmentModel()
        );
    }
}
