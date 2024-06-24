<?php

namespace Tests\Feature\Traits;

use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionTranslation;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Option\ProductOptionValueTranslation;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductTranslation;

trait CreateProductForBulkEdit
{

    protected function createProducts($language_id)
    {

        Product::factory(3)->create(['title' => 'test001 title']);
        Product::factory(2)->create(['title' => 'test001 title not exact']);
        Product::factory(5)->create(['title' => 'test002 title']);

        $products = Product::factory(10)->create(['title' => 'test002 title']);


        ProductTranslation::factory()->create([
            'product_id' => $products[0]->id,
            'title' => 'test001 translation title',
            'summary' => 'test001 translation title',
            'language_id'=>$language_id
        ]);
        ProductTranslation::factory()->create([
            'product_id' => $products[1]->id,
            'title' => 'test001 translation title not exact',
            'summary' => 'test001 translation title not exact',
            'language_id'=>$language_id
        ]);
        ProductTranslation::factory()->create([
            'product_id' => $products[2]->id,
            'title' => 'test002 translation title',
            'summary' => 'test002 translation title',
            'language_id'=>$language_id
        ]);

        ProductDetail::factory()->create([
            'product_id' => $products[0]->id,
            'summary' => 'test001 title'
        ]);
        ProductDetail::factory()->create([
            'product_id' => $products[1]->id,
            'summary' => 'test001 title not exact'
        ]);
        ProductDetail::factory()->create([
            'product_id' => $products[2]->id,
            'summary' => 'test002 title'
        ]);

        ProductOption::factory()->create([
            'product_id' => $products[0]->id,
            'name' => 'test001 title'
        ]);
        ProductOption::factory()->create([
            'product_id' => $products[1]->id,
            'name' => 'test001 title not exact'
        ]);
        ProductOption::factory()->create([
            'product_id' => $products[2]->id,
            'name' => 'test002 title'
        ]);

        $option = ProductOption::factory()->create([
            'product_id' => $products[3]->id,
            'name' => 'test002 title'
        ]);
        ProductOptionTranslation::factory()->create([
            'product_option_id' => $option->id,
            'name' => 'test001 translation title',
            'language_id'=>$language_id
        ]);

        $optionValue = ProductOptionValue::factory()->create([
            'option_id' => $option->id,
            'name' => 'test001 title'
        ]);
        ProductOptionValueTranslation::factory()->create([
            'product_option_value_id' => $optionValue->id,
            'name' => 'test001 translation title',
            'language_id'=>$language_id
        ]);
        $option = ProductOption::factory()->create([
            'product_id' => $products[4]->id,
            'name' => 'test002 title'
        ]);
        ProductOptionTranslation::factory()->create([
            'product_option_id' => $option->id,
            'name' => 'test001 translation title',
            'language_id'=>$language_id
        ]);
        $optionValue = ProductOptionValue::factory()->create([
            'option_id' => $option->id,
            'name' => 'test001 title'
        ]);
        ProductOptionValueTranslation::factory()->create([
            'product_option_value_id' => $optionValue->id,
            'name' => 'test001 translation title',
            'language_id'=>$language_id
        ]);
        $option = ProductOption::factory()->create([
            'product_id' => $products[5]->id,
            'name' => 'test002 title'
        ]);
        ProductOptionTranslation::factory()->create([
            'product_option_id' => $option->id,
            'name' => 'test001 translation title not exact',
            'language_id'=>$language_id
        ]);
        $optionValue = ProductOptionValue::factory()->create([
            'option_id' => $option->id,
            'name' => 'test001 title not exact'
        ]);
        ProductOptionValueTranslation::factory()->create([
            'product_option_value_id' => $optionValue->id,
            'name' => 'test001 translation title not exact',
            'language_id'=>$language_id
        ]);
        $option = ProductOption::factory()->create([
            'product_id' => $products[6]->id,
            'name' => 'test002 title'
        ]);
        ProductOptionTranslation::factory()->create([
            'product_option_id' => $option->id,
            'name' => 'test002 title',
            'language_id'=>$language_id
        ]);
        $optionValue = ProductOptionValue::factory()->create([
            'option_id' => $option->id,
            'name' => 'test002 title'
        ]);
        ProductOptionValueTranslation::factory()->create([
            'product_option_value_id' => $optionValue->id,
            'name' => 'test002 title',
            'language_id'=>$language_id
        ]);
        $option = ProductOption::factory()->create([
            'product_id' => $products[7]->id,
            'name' => 'test002 title'
        ]);
        ProductOptionTranslation::factory()->create([
            'product_option_id' => $option->id,
            'name' => 'test002 title',
            'language_id'=>$language_id
        ]);
        $optionValue = ProductOptionValue::factory()->create([
            'option_id' => $option->id,
            'name' => 'test002 title'
        ]);
        ProductOptionValueTranslation::factory()->create([
            'product_option_value_id' => $optionValue->id,
            'name' => 'test002 title',
            'language_id'=>$language_id
        ]);
    }
}
