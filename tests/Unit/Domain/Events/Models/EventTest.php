<?php

namespace Tests\Unit\Domain\Events\Models;

use Database\Seeders\CountrySeeder;
use Database\Seeders\EventSeeder;
use Database\Seeders\StateSeeder;
use Domain\Events\Models\Event;
use Tests\TestCase;

class EventTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([StateSeeder::class, CountrySeeder::class, EventSeeder::class]);
//        Event::factory()->create(['webaddress' => 'www.test.com']);
    }

    /** @test  */
    public function can_seed()
    {
//        $this->withoutExceptionHandling();
        $this->assertGreaterThanOrEqual(1, Event::count());
    }
}
