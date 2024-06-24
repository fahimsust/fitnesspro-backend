<?php

namespace Domain\Orders\Actions\Checkout\Shipment;

use Domain\Orders\Collections\CheckoutShipmentDtosCollection;
use Domain\Orders\Dtos\CheckoutItemDto;
use Domain\Orders\Dtos\CheckoutShipmentDto;
use Domain\Orders\Models\Carts\Cart;
use Support\Contracts\AbstractAction;

class BuildShipmentDtosFromCart extends AbstractAction
{
    private CheckoutShipmentDtosCollection $shipments;

    public function __construct(
        public Cart $cart
    )
    {
        $this->shipments = new CheckoutShipmentDtosCollection();
    }

    public function execute(): CheckoutShipmentDtosCollection
    {
        $this->cart->items->each->setRelation('cart', $this->cart);
        $this->cart->items->loadMissing([
            'product' => fn($query) => $query
                ->with([
                    'defaultAvailability',
                    'details'
                ]),
            'distributor',
            'discountAdvantages',
            'registryItem',
            'parentItem',
            'customFields'
        ]);

        $this->cart->items
            ->map(
                CheckoutItemDto::fromCartItem(...)
            )
            ->each(
                $this->assignItemToShipmentDtos(...)
            );

        AssignCartItemDiscountsToShipmentDtos::now(
            $this->shipments
        );

        return $this->shipments;
    }

    protected function assignItemToShipmentDtos(CheckoutItemDto $item): void
    {
        AssignItemDtoToShipmentDtos::now(
            $item,
            $this->shipments,
        );
    }

    public function hasRegistryShipments(): bool
    {
        return $this->shipments->firstWhere(
            fn(CheckoutShipmentDto $shipment) => $shipment->isRegistryShipment()
        );
    }
}
