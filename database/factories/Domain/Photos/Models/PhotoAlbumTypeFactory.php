<?php

namespace Database\Factories\Domain\Photos\Models;

use Domain\Photos\Models\PhotoAlbumType;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhotoAlbumTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PhotoAlbumType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(2, true),
        ];
    }
}
