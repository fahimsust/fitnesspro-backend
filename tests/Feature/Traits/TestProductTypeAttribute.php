<?php

namespace Tests\Feature\Traits;

use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Attribute\AttributeSet;
use Domain\Products\Models\Attribute\AttributeSetAttribute;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAttribute;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductType;
use Domain\Products\Models\Product\ProductTypeAttributeSet;
use Illuminate\Support\Collection;

trait TestProductTypeAttribute
{
    protected Product $product;
    protected ProductType $productType;

    protected function createProductTypeAttributeWithOption()
    {
        $this->product = Product::factory()->create();
        $this->productType = ProductType::factory()->create();
        ProductDetail::factory()->create(['product_id'=>$this->product->id,'type_id'=>$this->productType->id]);
        $attributeSets = AttributeSet::factory(5)->create();
        $attributes = Attribute::factory(10)->create();
        foreach($attributeSets as $value)
        {
            ProductTypeAttributeSet::factory()->create(['set_id'=>$value->id,'type_id'=>$this->productType->id]);
            AttributeSetAttribute::factory()->create(['attribute_id'=>$attributes[rand(0,4)]->id,'set_id'=>$value->id]);
            AttributeSetAttribute::factory()->create(['attribute_id'=>$attributes[rand(5,9)]->id,'set_id'=>$value->id]);
        }
        foreach($attributes as $value)
        {
            $options = AttributeOption::factory(10)->create(['attribute_id'=>$value->id]);
            ProductAttribute::factory()->create(['option_id'=>$options[rand(0,9)]->id,'product_id'=>$this->product->id]);
        }
    }
}
