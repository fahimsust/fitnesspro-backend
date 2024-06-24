<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use Domain\Content\Models\Image;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductImage;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductImagesControllerTest extends ControllerTestCase
{
    private $product;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->product = Product::factory()->create();
    }

    /** @test */
    public function can_get_product_images()
    {
        ProductImage::factory(5)->create(['product_id'=>$this->product->id]);

        $this->getJson(route('admin.product-images',['product_id'=>$this->product->id]))
            ->assertOk()
            ->assertJsonCount(5,'data')
            ->assertJsonStructure(['data'=>["*" => ['id', 'caption','rank','show_in_gallery','image']]]);
    }
    /** @test */
    public function can_search_product_images()
    {
        $product = Product::factory()->create();
        $images = Image::factory(2)->create(['name'=>'test001']);
        $imageNotMatches = Image::factory(2)->create(['name'=>'not_matched','default_caption'=>'not_matched']);
        ProductImage::factory()->create(['product_id'=>$this->product->id,'image_id'=>$images[0]->id]);
        ProductImage::factory()->create(['product_id'=>$this->product->id,'image_id'=>$images[1]->id]);
        ProductImage::factory()->create(['product_id'=>$this->product->id,'image_id'=>$imageNotMatches[0]->id,'caption'=>'not_matched']);
        ProductImage::factory()->create(['product_id'=>$this->product->id,'image_id'=>$imageNotMatches[1]->id,'caption'=>'test001']);
        ProductImage::factory()->create(['product_id'=>$product->id,'image_id'=>$images[1]->id,'caption'=>'test001']);

        $this->getJson(route('admin.product-images',['product_id'=>$this->product->id,'keyword'=>'test001']))
            ->assertOk()
            ->assertJsonCount(3,'data')
            ->assertJsonStructure(['data'=>["*" => ['id', 'caption','rank','show_in_gallery','image']]]);
    }
}
