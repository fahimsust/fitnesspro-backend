<?php

namespace Tests\Unit\Domain\Trips\Models;

use Illuminate\Support\Facades\Date;
use Tests\Feature\Domain\Trips\TripsTestCase;

class TripsTest extends TripsTestCase
{
    /** @test */
    public function can_get_accounts_upcoming_trips()
    {
        $this->createFutureTrip();

        $upcomingTrips = $this->trips->upcoming(30, 3);

        $this->assertCount(1, $upcomingTrips);
    }

    /** @test */
    public function can_get_accounts_past_trips()
    {
        $this->createPastTrip();

        //        dd($this->trips->all());

        $pastTrips = $this->trips->past(
            72,
            Date::now()->subDays(70)->format('Y-m-d'),
            Date::now()->subDays(2)->format('Y-m-d')
        );

        $this->assertCount(1, $pastTrips);
    }

    /** @test */
    public function can_get_all_trips_for_an_account()
    {
        $this->createFutureTrip();
        $this->createPastTrip();

        //        dump($this->trips->all());
        //
        $allTrips = $this->trips->all();

        $this->assertCount(2, $allTrips);
    }

    /** @test */
    public function can_get_trip_flyer()
    {
        $this->createFutureTrip();

        //        dd($this->trips->all(),
        //            [
        //                'order' => Order::first()->toArray(),
        //                'shipment' => Shipment::first()->toArray(),
        //                'package' => OrderPackage::first()->toArray(),
        //                'orderproduct' => OrderProduct::first()->toArray(),
        //                'product' => Product::first()->toArray(),
        //                'productdetail' => ProductDetail::first()->toArray(),
        //                'attributeoption' => AttributeOption::first()->toArray(),
        //                'productattribute' => ProductAttribute::first()->toArray(),
        //                'orderproductoption' => OrderProductOption::first()->toArray(),
        //                'productoptionvalue' => ProductOptionValue::first()->toArray()
        //            ]
        //        );

        $trip = $this->trips->first();
        $flyer = $this->createTripFlyer($trip->id);

        $this->assertNotNull($flyer->flyer_pdf_url);
        $this->assertNotNull($flyer->voucher_pdf_url);
    }
}
