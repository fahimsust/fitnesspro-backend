<?php

namespace Tests\Feature\Traits;

use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAttribute;
use Illuminate\Database\Eloquent\Collection;

trait CreateProductForAttribute
{
    protected Collection $products;
    protected AttributeOption $productOptionInAllFifty;
    protected AttributeOption $productOptionInFirstFourty;
    protected AttributeOption $productOptionInFirstThirty;
    protected AttributeOption $productOptionInFirstTwenty;
    protected AttributeOption $productOptionInFirstTen;
    protected function createAttributeProducts()
    {
        $this->products = Product::factory(100)->create();
        $this->productOptionInAllFifty = AttributeOption::factory()->create();
        $this->productOptionInFirstFourty = AttributeOption::factory()->create();
        $this->productOptionInFirstThirty = AttributeOption::factory()->create();
        $this->productOptionInFirstTwenty = AttributeOption::factory()->create();
        $this->productOptionInFirstTen = AttributeOption::factory()->create();
        foreach($this->products as $key=>$value)
        {
            if($key < 50 )
            {
                ProductAttribute::factory()->create(['product_id'=>$value->id,'option_id'=>$this->productOptionInAllFifty->id]);
                if($key >= 30 && $key < 40)
                {
                    ProductAttribute::factory()->create(['product_id'=>$value->id,'option_id'=>$this->productOptionInFirstFourty->id]);
                }
                if($key >= 20 && $key < 30)
                {
                    ProductAttribute::factory()->create(['product_id'=>$value->id,'option_id'=>$this->productOptionInFirstThirty->id]);
                }
                if($key >= 10 && $key < 20)
                {
                    ProductAttribute::factory()->create(['product_id'=>$value->id,'option_id'=>$this->productOptionInFirstTwenty->id]);
                }
                if($key < 10)
                {
                    ProductAttribute::factory()->create(['product_id'=>$value->id,'option_id'=>$this->productOptionInFirstTen->id]);
                }
            }
        }
    }
}
