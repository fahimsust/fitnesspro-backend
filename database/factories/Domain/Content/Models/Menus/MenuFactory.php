<?php

namespace Database\Factories\Domain\Content\Models\Menus;

use Domain\Content\Models\Menus\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    protected $model = Menu::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'url_name' => $this->faker->unique()->slug(2),
            'status'=>1
        ];
    }
}
