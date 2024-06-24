<?php

namespace Database\Factories\Domain\Resorts\Models;

use Domain\Locales\Models\Country;
use Domain\Locales\Models\Region;
use Domain\Locales\Models\StateProvince;
use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Resorts\Models\Resort;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResortFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Resort::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'attribute_option_id' => function () {
                return $this->resortAttribute();
            },
            'description' => $this->faker->randomHtml(), //$this->faker->words(5, true),
            'comments' => '',
            'logo' => $this->faker->imageUrl(),
            'fax' => $this->faker->phoneNumber,
            'contact_addr' => $this->faker->address,
            'contact_city' => $this->faker->city,
            'contact_state_id' => function () {
                return StateProvince::first()->id;
            },
            'contact_zip' => $this->faker->postcode,
            'contact_country_id' => function () {
                return Country::first()->id;
            },
            'mgr_lname' => $this->faker->lastName,
            'mgr_fname' => $this->faker->firstName,
            'mgr_phone' => $this->faker->phoneNumber,
            'mgr_email' => $this->faker->email,
            'mgr_fax' => $this->faker->phoneNumber,
            'notes' => '',
            'transfer_info' => $this->faker->randomHtml(),
            'url_name' => $this->faker->unique()->slug(2),
            'details' => 0,
            'schedule_info' => '',
            'suz_comments' => '',
            'link_resort' =>  '',
            'concierge_name' => $this->faker->name,
            'concierge_email' => $this->faker->email,
            'facebook_fanpage' => '',
            'giftfund_info' => '',
            'resort_type' => function () {
                return $this->resortTypeAttribute();
            },
            'region_id' => function () {
                return Region::first()->id;
            },
            'airport_id' => function () {
                return $this->airportAttribute();
            },
            'mobile_background_image' => '',
        ];
    }

    private function resortAttribute()
    {
        $attribute = Attribute::factory()->create(['name' => 'Resort']);

        return AttributeOption::factory()->create(['attribute_id' => $attribute->id])->id;
    }

    private function airportAttribute()
    {
        $attribute = Attribute::factory()->create(['name' => 'Airport']);

        return AttributeOption::factory()->create(['attribute_id' => $attribute->id])->id;
    }

    private function resortTypeAttribute()
    {
        $attribute = Attribute::factory()->create(['name' => 'Resort Type']);

        return AttributeOption::factory()->create(['attribute_id' => $attribute->id])->id;
    }
}
