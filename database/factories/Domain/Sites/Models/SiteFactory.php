<?php

namespace Database\Factories\Domain\Sites\Models;

use Domain\Sites\Enums\RequireLogin;
use function config;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Site::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;

        return [
//            'id'=>1,
            'name' => $faker->company,
            'domain' => $faker->domainName,
            'email' => $faker->email,
            'phone' => $faker->phoneNumber,
            'url' => $faker->url,
            'status' => false,
            'offline_message' => '<p>'.implode('</p><p>', $faker->paragraphs(2)).'</p>',
            'offline_key' => $faker->randomNumber(7),
            'meta_title' => $faker->company,
            'meta_keywords' => $faker->words(3, true),
            'meta_desc' => substr($faker->words(10, true), 0, 255),
            'account_type_id' => 0,
            'require_login' => RequireLogin::None,
            'required_account_types' =>null,
            'version' => config('app.version'),
            'template_set' => '',
            'theme_id' => 1,
            'apply_updates' => true,
            'logo_url' => ""
        ];
    }
}
