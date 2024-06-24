<?php

namespace Database\Factories\Domain\Photos\Models;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Domain\Photos\Models\PhotoAlbum;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhotoAlbumFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PhotoAlbum::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence,
            'type' => 1,
            'type_id' => function () {
                return Account::firstOrFactory()->id;
            },
            'recent_photo_id' => 0,
            'updated' => Carbon::now(),
            'photos_count' => 0,
        ];
    }
}
