<?php

namespace Database\Factories\Domain\Content\Models\Pages;

use Domain\Content\Models\Pages\PageCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageCategoryFactory extends Factory
{
    protected $model = PageCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->title,
            'url_name' => $this->faker->unique()->slug(2),
            'status'=>$this->faker->boolean,
        ];
    }
}
