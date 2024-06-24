<?php

namespace Database\Factories\Domain\Modules\Models;

use Domain\Modules\Models\Module;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Module::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'file' => $this->faker->title,
            'config_values' => $this->faker->words(3,true),
            'description' => $this->faker->words(2,true),
            'showinmenu'=>$this->faker->boolean,
        ];
    }
}
