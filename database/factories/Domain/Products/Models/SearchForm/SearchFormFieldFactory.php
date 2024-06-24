<?php

namespace Database\Factories\Domain\Products\Models\SearchForm;

use Domain\Content\Models\Element;
use Domain\Products\Models\SearchForm\SearchForm;
use Domain\Products\Models\SearchForm\SearchFormField;
use Illuminate\Database\Eloquent\Factories\Factory;

class SearchFormFieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SearchFormField::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'search_id' => SearchForm::firstOrFactory(),
            'help_element_id' => Element::firstOrFactory(),
            'display' => $this->faker->word,
            'type'=>$this->faker->randomDigit,
            'search_type'=>$this->faker->boolean,
            'rank'=>$this->faker->randomDigit,
            'status'=>$this->faker->boolean,
            'cssclass'=>$this->faker->word,
        ];
    }
}
