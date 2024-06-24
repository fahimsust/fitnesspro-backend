<?php

namespace Domain\Orders\Actions\Checkout\Shipment;

use Domain\Addresses\Actions\LoadAddressById;
use Domain\Orders\Actions\Shipping\CalculateShippingRatesForShipmentDtos;
use Domain\Orders\Dtos\CheckoutShipmentDto;
use Domain\Orders\Exceptions\CheckoutAlreadyCompletedException;
use Domain\Orders\Models\Checkout\Checkout;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;
use Support\Dtos\AddressDto;
use Symfony\Component\HttpFoundation\Response;

class SaveAndRateShipmentsForCheckout extends AbstractAction
{
    private Collection $checkoutShipments;
    private Collection $shipmentDtos;

    public function __construct(
        public Checkout $checkout,
    )
    {
    }

    public function execute(): Collection
    {
        CheckoutAlreadyCompletedException::check($this->checkout);

        if($this->checkout->shipping_address_id === null) {
            throw new \Exception(
                __('Shipping address not set'),
                Response::HTTP_PRECONDITION_FAILED
            );
        }

        $this->findCreateCheckoutShipments();
        $this->buildDtosFromModels();

        if (
            !$this->shipmentDtos->contains(
                fn(CheckoutShipmentDto $dto) => $dto->shipment->needsNewRates()
            )
        ) {
            return $this->shipmentDtos;
        }

        CalculateShippingRatesForShipmentDtos::now(
            AddressDto::fromModel(
                LoadAddressById::now($this->checkout->shipping_address_id)
            ),
            $this->shipmentDtos->filter(
                fn(CheckoutShipmentDto $dto) => $dto->shipment->needsNewRates()
            )
        )
            ->each(
                $this->saveRatesToModel(...)
            );

        return $this->shipmentDtos;
    }

    private function findCreateCheckoutShipments(): void
    {
        $this->checkoutShipments = FindCreateShipmentsForCheckout::now($this->checkout)
            ->keyBy('id');
    }

    private function buildDtosFromModels(): void
    {
        $this->shipmentDtos = BuildShipmentDtosFromCheckoutShipments::now(
            $this->checkoutShipments
        )
            ->keyBy('id');
    }

    private function saveRatesToModel(CheckoutShipmentDto $dto): void
    {
        $model = $this->checkoutShipments->get($dto->id);

        $model->update([
            'latest_rates' => $dto->rates,
            'rated_at' => now(),
        ]);

        $this->shipmentDtos->get($dto->id)
            ->model($model);
    }
}
