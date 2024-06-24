<?php

namespace Tests\Feature\App\Api\Accounts\Controllers;

use Illuminate\Support\Facades\Date;
use Illuminate\Validation\ValidationException;
use function route;
use Tests\Feature\Domain\Trips\TripsTestCase;

class TripControllerTest extends TripsTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->apiTestToken();
    }

    private function createMultipleFutureTrips($count = 48)
    {
        for ($x = 0; $x < $count; $x++) {
            $this->createFutureTrip();
        }
    }

    /** @test */
    public function can_get_accounts_trips()
    {
        $this->createFutureTrip();
        $this->createPastTrip();

        $response = $this->getJson(route('mobile.account.trip.index', $this->account->id))
            ->assertOk();
//        dd($response['trips']['data'][0]);

        $this->assertCount(2, $response['trips']['data']);
    }

    /** @test */
    public function can_paginate_trips()
    {
        $this->createMultipleFutureTrips();

        $firstPageResponse = $this->getJson(route('mobile.account.trip.index', $this->account->id))
            ->assertOk();

        $this->assertEquals(48, $firstPageResponse['trips']['total']);
        $this->assertEquals(1, $firstPageResponse['trips']['current_page']);

        $secondPageResponse = $this->json(
            'GET',
            route('mobile.account.trip.index', $this->account->id),
            ['page' => 2]
        )->assertOk();

        $this->assertEquals(2, $secondPageResponse['trips']['current_page']);
        $this->assertCount(23, $secondPageResponse['trips']['data']);
    }

    /** @test */
    public function can_search_trips()
    {
        $this->createMultipleFutureTrips(5);
        $this->createFutureTrip(45);

        $testLimitAndPage = $this->json(
            'GET',
            route('mobile.account.trip.index', $this->account->id),
            [
                'limit' => 2, 'page' => 2,
                'trip_starts' => [
                    'start' => Date::now()->format('Y-m-d H:i:s'),
                    //                    'end' => Date::now()->subDay()->format("Y-m-d H:i:s")
                ],
            ]
        );

        $testLimitAndPage->assertOk();

        $this->assertEquals(6, $testLimitAndPage['trips']['total']);
        $this->assertCount(2, $testLimitAndPage['trips']['data']);
        $this->assertEquals(2, $testLimitAndPage['trips']['current_page']);
        $this->assertEquals(4, $testLimitAndPage['trips']['to']);

        $testStartDate = $this->json(
            'GET',
            route('mobile.account.trip.index', $this->account->id),
            [
                'trip_starts' => [
                    'start' => Date::now()->addDays(48)->format('Y-m-d H:i:s'),
                    'end' => Date::now()->addDays(52)->format('Y-m-d H:i:s'),
                ],
                'trip_ends' => [
                    'start' => Date::now()->addDays(54)->format('Y-m-d H:i:s'),
                    'end' => Date::now()->addDays(60)->format('Y-m-d H:i:s'),
                ],
            ]
        )->assertOk();

        $this->assertEquals(1, $testStartDate['trips']['total']);
        $this->assertCount(1, $testStartDate['trips']['data']);
    }

    /** @test */
    public function invalid_start_date_fails()
    {
        $this->withoutExceptionHandling();
        $this->expectException(ValidationException::class);

        $this->json(
            'GET',
            route('mobile.account.trip.index', $this->account->id),
            [
                'trip_starts' => ['start' => Date::now()->format('Y-m-d H:i')],
            ]
        );
    }

    /** @test */
    public function invalid_limit_fails()
    {
        $this->withoutExceptionHandling();
        $this->expectException(ValidationException::class);

        $this->json(
            'GET',
            route('mobile.account.trip.index', $this->account->id),
            [
                'limit' => 26,
            ]
        );
    }

    /** @test */
    public function invalid_page_fails()
    {
        $this->withoutExceptionHandling();
        $this->expectException(ValidationException::class);

        $this->json(
            'GET',
            route('mobile.account.trip.index', $this->account->id),
            [
                'page' => 0,
            ]
        );
    }

    /** @todo */
    public function can_get_trip_details()
    {
        $this->withoutExceptionHandling();

        $this->createFutureTrip();
        $trip = $this->trips->first();
        $flyer = $this->createTripFlyer($trip->id);

        $response = $this->getJson(route('mobile.account.trip.show', [$this->account, $trip->id]))
            ->assertOk();
//        dd($response['trip']);

        $this->assertEquals($trip->id, $response['trip']['id']);
        $this->assertEquals($flyer->id, $response['flyer']['id']);
        $this->assertNotNull($response['flyer']['flyer_pdf_url']);
        $this->assertNotNull($response['flyer']['voucher_pdf_url']);
    }
}
