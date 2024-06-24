<?php

namespace Database\Factories\Domain\Content\Models\Menus;

use Domain\Content\Models\Menus\Menu;
use Domain\Content\Models\Menus\MenusPages;
use Domain\Content\Models\Pages\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenusPagesFactory extends Factory
{
    protected $model = MenusPages::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'page_id'=>Page::firstOrFactory(),
            'menu_id'=>Menu::firstOrFactory(),
            'rank'=>$this->faker->randomDigit,
            'target'=>$this->faker->randomElement(['_blank','_self','_parent','_top']),
            'sub_pagemenu_id'=>$this->faker->randomDigit,
            'sub_categorymenu_id'=>$this->faker->randomDigit,
        ];
    }
}
