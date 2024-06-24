<?php

namespace Domain\Orders\Contracts;

interface ItemDto
{
    public function createShipmentDtoWith(): ShipmentDto;
    public function createPackageDtoWith(): PackageDto;
}
