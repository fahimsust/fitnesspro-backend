<?php

namespace Database\Factories\Domain\Products\Models\SearchForm;

use Domain\Products\Models\SearchForm\SearchForm;
use Illuminate\Database\Eloquent\Factories\Factory;

class SearchFormFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SearchForm::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'status'=>true,
        ];
    }
}
