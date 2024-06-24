<?php

namespace Domain\Orders\Enums\Shipping;

use Domain\Distributors\Models\Shipping\DistributorUps;
use Domain\Orders\Actions\Services\Shipping\Ups\GetUpsRatesShippingServiceAction;
use Domain\Orders\Contracts\ShipmentDto;
use Domain\Orders\Contracts\ShippingServiceAction;
use Domain\Orders\Contracts\ShippingServiceModel;
use Illuminate\Support\Collection;
use Support\Dtos\AddressDto;

enum ShippingGateways: int
{
    case Ups = 2;

    public function getRates(
        AddressDto  $address,
        ShipmentDto $shipment,
        Collection  $availableMethods,
    ): Collection
    {
        return $this->serviceAction(
            $address,
            $shipment,
            $availableMethods
        )->execute();
    }

    protected function serviceAction(
        AddressDto  $address,
        ShipmentDto $shipment,
        Collection  $availableMethods,
    ): ShippingServiceAction
    {
        return resolve(
            $this->serviceActionClass(),
            [
                'serviceModel' => $this->serviceDistributorModel($shipment->distributorId),
                'address' => $address,
                'shipment' => $shipment,
                'availableMethods' => $availableMethods
            ]
        );
    }

    public function serviceActionClass(): string
    {
        return match ($this) {
            self::Ups => GetUpsRatesShippingServiceAction::class,
        };
    }

    public function serviceDistributorModel(int $distributorId): ?ShippingServiceModel
    {
        return $this->serviceDistributorModelClass()::where('distributor_id', $distributorId)
            ->where('shipping_gateway_id', $this->value)
            ->first();
    }

    public function serviceDistributorModelClass(): string
    {
        return match ($this) {
            self::Ups => DistributorUps::class,
        };
    }
}
