<?php

namespace Domain\Orders\Traits;

use Domain\Distributors\Models\Distributor;
use Domain\Future\GiftRegistry\GiftRegistry;
use Domain\Orders\Contracts\PackageDto;
use Illuminate\Support\Collection;

trait IsShipmentDto
{
    public function __construct(
        public bool          $isDigital = false,
        public bool          $isDropShip = false,

        public float         $shipCost = 0,

        public ?int          $shippingMethodId = null,
        public ?string       $shippingMethodLabel = null,

        public ?int          $distributorId = null,
        public ?Distributor  $distributor = null,

        public ?int          $id = null,
        public ?Collection   $packages = new Collection(),

        public ?GiftRegistry $registry = null,

    )
    {
    }

    public function hasRoom(float $itemWeight): bool
    {
        if ($this->isDigital) {
            return true;
        }

        return $this->roomLeftInWeight() >= $itemWeight;
    }

    public function roomLeftInWeight(): float
    {
        return bcsub(config('shipments.max_weight'), $this->weight());
    }


    public function weight(): float
    {
        return $this->packages->reduce(
            fn(?float $carry, PackageDto $package) => bcadd($carry, $package->weight()),
            0
        );
    }

    public function isRegistryShipment(): bool
    {
        return !is_null($this->registry);
    }
}
