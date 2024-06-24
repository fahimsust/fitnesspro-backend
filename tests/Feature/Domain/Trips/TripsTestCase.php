<?php

namespace Tests\Feature\Domain\Trips;

use Database\Seeders\ShipmentStatusSeeder;
use Domain\Orders\Models\Order\Shipments\ShipmentStatus;
use Domain\Trips\Models\TripFlyer;
use Domain\Trips\QueryBuilders\AccountTrip;
use Domain\Trips\Seeders\Seeder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Tests\TestCase;

abstract class TripsTestCase extends TestCase
{
    protected int $resortAttributeId;

    protected int $vacationTypeId;

    /**
     * @var AccountTrip
     */
    protected AccountTrip $trips;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createTestAccount();

        $this->seed(ShipmentStatusSeeder::class);
        $this->startTripsQuery();
    }

    protected function startTripsQuery()
    {
        $this->trips = new AccountTrip($this->account);
    }

    protected function createFutureTrip($pushStartDateByDays = 0): void
    {
        $trip = new Seeder($this->account);
        $trip
            ->startDate(Date::now()->addDays($pushStartDateByDays + 5))
            ->endDate(Date::now()->addDays($pushStartDateByDays + 11))
            ->orderStatus($this->confirmedOrderStatusId())
            ->create();
    }

    protected function createPastTrip()
    {
        $trip = new Seeder($this->account);
        $trip
            ->startDate(Date::now()->subDays(21))
            ->endDate(Date::now()->subDays(14))
            ->orderStatus($this->confirmedOrderStatusId())
            ->create();
    }

    /**
     * @param $tripId
     * @return Collection|Model|mixed
     */
    protected function createTripFlyer($tripId)
    {
        return TripFlyer::factory()->create(['orders_products_id' => $tripId]);
    }

    /**
     * @return mixed
     */
    protected function confirmedOrderStatusId()
    {
        return ShipmentStatus::whereName('Confirmed')->first()->id;
    }
}
