<?php

namespace Tests\RequestFactories\App\Api\Admin\Products\Requests;

use Domain\Distributors\Models\Distributor;
use Worksome\RequestFactories\RequestFactory;

class CreateProductRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        $salePrice = 0;
        $regularPrice = $this->faker->randomNumber(6);

        if($onsale = $this->faker->boolean())
            $salePrice = $regularPrice - round($regularPrice * (mt_rand(1, 15) / 100));

        return [
            'subtitle' => $this->faker->title,
            'title' => $this->faker->title,
            'url_name' => $this->faker->unique()->slug(2),
            'product_no' => $this->faker->word,
            'default_distributor_id' => Distributor::firstOrFactory()->id,
            'weight'=>$this->faker->randomNumber(2),
            'onsale'=>$onsale,
            'price_reg'=>$regularPrice,
            'price_sale'=>$salePrice,
            'min_qty'=>0,
            'max_qty'=>$this->faker->randomNumber(1),
            'feature'=>$this->faker->boolean,
            'summary'=>$this->faker->text,
            'description'=>$this->faker->text,
            'product_attributes'=>$this->faker->text,
        ];
    }
}
