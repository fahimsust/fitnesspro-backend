<?php

namespace Database\Factories\Domain\Modules\Models;

use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleField;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModuleFieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ModuleField::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;
        $field_setting = [
            [
                "type" => "option",
                "options" => [
                    ["id" => "show", "name" => "Show"],
                    ["id" => "hide", "name" => "Hide"]
                ]
            ],
            [
                "type" => "option",
                "options" => [
                    ["id" => 1, "name" => $faker->company],
                    ["id" => 2, "name" => $faker->company],
                    ["id" => 3, "name" => $faker->company],
                    ["id" => 4, "name" => $faker->company]
                ]
            ],
            [
                "type" => "query",
                "query" => "Select id,title as name from categories where status = 1"
            ],
            ["type" => "text"],
            ["type" => "number"]
        ];
        $randomKey = array_rand($field_setting);
        $randomValue = $field_setting[$randomKey];
        return [
            'module_id' => Module::firstOrFactory(),
            'field_name' => $this->faker->word,
            'field_setting' => json_encode($randomValue)
        ];
    }
}
