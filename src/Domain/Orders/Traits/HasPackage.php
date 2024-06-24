<?php

namespace Domain\Orders\Traits;


use Domain\Orders\Models\Order\Shipments\OrderPackage;

trait HasPackage
{
    public ?OrderPackage $package = null;

    public function package(OrderPackage $package): static
    {
        $this->package = $package;

        return $this;
    }
}
