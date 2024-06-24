<?php

namespace Domain\Orders\Actions\Order\Shipment;


use Domain\Orders\Actions\Order\Package\CreatePackageFromDto;
use Domain\Orders\Dtos\OrderPackageDto;
use Domain\Orders\Dtos\OrderShipmentDto;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Domain\System\Models\System;
use Illuminate\Database\Eloquent\Model;
use Support\Contracts\AbstractAction;

class CreateShipmentFromDto extends AbstractAction
{
    public Shipment|Model $shipment;

    public function __construct(
        public Order            $order,
        public OrderShipmentDto $shipmentDto,
        public bool             $isPaid,
        public int              $defaultStatusId
    )
    {
    }

    private function sys()
    {
        return app(System::class);
    }

    public function result(): Shipment
    {
        return $this->shipment;
    }

    public function execute(): static
    {
        if ($this->isPaid && $this->shipmentDto->isDigital == 1) {
            $this->defaultStatusId = $this->sys()
                ->orderPlacedDefaultStatus()['download'];
        } else if ($this->shipmentDto->isDropShip == 1 && $this->isPaid) {
            $this->defaultStatusId = $this->sys()
                ->orderPlacedDefaultStatus()['dropship'];
        }

        return $this->recordShipment()
            ->recordPackages();
    }

    protected function recordShipment(): static
    {
        $this->shipment = $this->order
            ->shipments()
            ->create(
                $this->shipmentDto
                    ->toOrderShipmentModel($this->defaultStatusId)
            );

        $this->shipment->setRelation('order', $this->order);

        $this->order->activity(__("Shipment Id :id created", [
            'id' => $this->shipment->id
        ]));

        return $this;
    }

    protected function recordPackages(): static
    {
        $this->shipmentDto
            ->packages
            ->each(
                fn(OrderPackageDto $packageDto) => CreatePackageFromDto::run(
                    $this->shipment,
                    $packageDto,
                )
            );

        return $this;
    }
}
