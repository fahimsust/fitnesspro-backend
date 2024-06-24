<?php

namespace Tests\Feature\App\Api\Support\Controllers;

use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use function route;


class CountryStateControllerTest extends TestCase
{
    private Collection $countries;

    protected function setUp(): void
    {
        parent::setUp();

        $this->countries = Country::factory(5)->create();
    }

    /** @test */
    public function can_get_countries()
    {
        $this->getJson(route('countries.list'))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(5)
            ->assertJsonStructure(
                [
                    '*' => [
                        'name',
                        'id',
                    ]
                ]
            );
    }
    /** @test */
    public function can_get_states()
    {
        StateProvince::factory(5)->create(['country_id'=>$this->countries->first()->id]);
        $this->getJson(route('states.list',[$this->countries->first()->id]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(5)
            ->assertJsonStructure(
                [
                    '*' => [
                        'name',
                        'id',
                    ]
                ]
            );
    }


}
