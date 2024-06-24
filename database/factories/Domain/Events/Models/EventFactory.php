<?php

namespace Database\Factories\Domain\Events\Models;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Domain\Events\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;

        $date = Carbon::now();

        return [
            'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
            'description' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
            'sdate' => $date->copy()->addMonths(1),
            'edate' => $date->copy()->addMonths(8),
            'created' => $date,
            'createdby' => Account::firstOrFactory(['status_id' => 1])->id,
            'photo' => null,
            'type' => 0, //Need to know custom-polymorphic-type with its relationships
            'type_id' => $faker->numberBetween($min = 0, $max = 9), //to know custom-polymorphic-type_id
            'city' => $faker->city,
            'state' => Str::substr(StateProvince::firstOrFactory()->abbreviation, 0, 2),
            'country' => Country::firstOrFactory()->abbreviation,
            'webaddress' => $faker->safeEmailDomain,
            'email' => $faker->safeEmail,
            'phone' => $faker->e164PhoneNumber,
            'views' => $faker->numberBetween($min = 1, $max = 100),
        ];
    }
}
