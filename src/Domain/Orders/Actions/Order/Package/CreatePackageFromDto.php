<?php

namespace Domain\Orders\Actions\Order\Package;


use Domain\Orders\Actions\Order\Package\Item\AddItemToOrderPackageFromDto;
use Domain\Orders\Dtos\OrderItemDto;
use Domain\Orders\Dtos\OrderPackageDto;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Illuminate\Database\Eloquent\Model;
use Support\Contracts\AbstractAction;

class CreatePackageFromDto extends AbstractAction
{
    private OrderPackage|Model $package;

    public function __construct(
        public Shipment        $shipment,
        public OrderPackageDto $packageDto,
    ) {
    }

    public function result(): OrderPackage
    {
        return $this->package;
    }

    public function execute(): static
    {
        $this->package = $this->shipment
            ->packages()
            ->create(
                $this->packageDto
                    ->shipment($this->shipment)
                    ->toPackageModel()
            );

        $this->packageDto
            ->items
            ->each(
                fn (OrderItemDto $item) => AddItemToOrderPackageFromDto::run(
                    $this->shipment,
                    $this->package,
                    $item
                )
            );

        return $this;
    }
}
