<?php

namespace Tests\Feature\App\Api\Events\Controllers;

use Database\Seeders\CountrySeeder;
use Database\Seeders\StateSeeder;
use Domain\Events\Models\Event;
use Illuminate\Support\Facades\Date;
use function route;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
    /**
     * @var mixed
     */
    private $event;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([CountrySeeder::class, StateSeeder::class]);
    }

    protected function createFutureEvents($count = 250): void
    {
        $events = Event::factory()->count($count)->create();

        $this->event = $events->first();
    }

    /** @test */
    public function can_get_events_and_paginate()
    {
        $this->createFutureEvents();

        $firstPageResponse = $this->getJson(route('mobile.event.index'))
            ->assertOk();

        $this->assertEquals(250, $firstPageResponse['events']['total']);
        $this->assertEquals(1, $firstPageResponse['events']['current_page']);

        $secondPageResponse = $this->json(
            'GET',
            route('mobile.event.index'),
            ['page' => 2]
        )->assertOk();

        $this->assertEquals(2, $secondPageResponse['events']['current_page']);
        $this->assertCount(25, $secondPageResponse['events']['data']);
    }

    /** @test */
    public function can_search_events_and_paginate()
    {
        $this->createFutureEvents(50);
        $pastEvents = Event::factory(['sdate' => Date::now()->subMonth()])->count(5)->create();

        $searchDate = Date::now()->format('Y-m-d H:i:s');
        $expectedCount = Event::where('sdate', '>=', $searchDate)->count();

        $testResponse = $this->json(
            'GET',
            route('mobile.event.index'),
            [
                'limit' => 2, 'page' => 2,
                'event_starts' => [
                    'start' => $searchDate,
                    //                    'end' => Date::now()->subDay()->format("Y-m-d H:i:s")
                ],
            ]
        )->assertOk();

        $this->assertEquals(50, $testResponse['events']['total']);
        $this->assertCount(2, $testResponse['events']['data']);
        $this->assertEquals(2, $testResponse['events']['current_page']);
        $this->assertEquals(4, $testResponse['events']['to']);
    }

    /** @test */
    public function can_search_title()
    {
        $this->createFutureEvents(2);

        $searchTitle = Event::first()->title;

        $testResponse = $this->json(
            'GET',
            route('mobile.event.index'),
            [
                'title' => $searchTitle,
            ]
        )->assertOk();

        $data = $testResponse['events']['data'];
        $this->assertCount(1, $data);
        $this->assertEquals($searchTitle, $data[0]['title']);
    }

    /** @test */
    public function can_search_city()
    {
        $this->createFutureEvents(2);

        $searchCity = Event::first()->city;

        $testResponse = $this->json(
            'GET',
            route('mobile.event.index'),
            [
                'city' => $searchCity,
            ]
        )->assertOk();

        $data = $testResponse['events']['data'];
        $this->assertCount(1, $data);
        $this->assertEquals($searchCity, $data[0]['city']);
    }

    /** @test */
    public function can_search_state()
    {
        $this->createFutureEvents(2);

        $searchState = Event::first()->state;

        $testResponse = $this->json(
            'GET',
            route('mobile.event.index'),
            [
                'state_alpha2' => $searchState,
            ]
        )->assertOk();

        $data = $testResponse['events']['data'];
        $this->assertCount(2, $data);
        $this->assertEquals($searchState, $data[0]['state']);
    }

    /** @test */
    public function can_search_country()
    {
        $this->createFutureEvents(2);

        $searchCountry = Event::first()->country;

        $testResponse = $this->json(
            'GET',
            route('mobile.event.index'),
            [
                'country_alpha2' => $searchCountry,
            ]
        )->assertOk();

        $data = $testResponse['events']['data'];
        $this->assertCount(2, $data);
        $this->assertEquals($searchCountry, $data[0]['country']);
    }

    /** @test */
    public function can_get_event_details()
    {
        $this->createFutureEvents(2);

        $firstEvent = Event::first();

        $response = $this->getJson(route('mobile.event.show', $firstEvent))
            ->assertOk();

        $this->assertEquals($firstEvent->id, $response['event']['id']);
        $this->assertNotNull($response['event']['account']);
        $this->assertNotNull($response['event']['state']);
        $this->assertNotNull($response['event']['country']);
    }
}
