<?php

namespace Database\Factories\Domain\Content\Models;

use Domain\Content\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'filename' => ltrim($this->faker->filePath(), '/'),
            'default_caption' => $this->faker->sentence,
            'name' => $this->faker->name,
            'inventory_image_id' => 0,
        ];
    }
}
