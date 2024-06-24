<?php

namespace Domain\Orders\Contracts;

interface ShipmentDto
{
    public function weight(): float;
    public function roomLeftInWeight(): float;
    public function hasRoom(float $itemWeight): bool;
    public function isRegistryShipment(): bool;

}
