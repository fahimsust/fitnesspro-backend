<?php

namespace Tests\Unit\Domain\Resorts\Models;

use Domain\Locales\Models\Country;
use Domain\Content\Models\Image;
use Domain\Photos\Models\Photo;
use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductImage;
use Domain\Resorts\Models\Resort;
use Tests\Feature\Domain\Resorts\ResortTestCase;

class ResortTest extends ResortTestCase
{


    protected function setUp(): void
    {
        parent::setUp();

        $this->createResort();
    }

    /** @test */
    public function can_seed()
    {
        $this->assertNotNull($this->resort->id);
    }

    /** @test */
    public function can_get_country()
    {
        $country = Country::first();

        $this->assertEquals(1, $this->resort->country->id);
    }

    /** @test */
    public function can_get_attribute_option()
    {
        $option = $this->getFirstAttributeOptionByName('Resort');

        $this->assertEquals($option->id, $this->resort->attributeOption->id);
    }

    /** @test */
    public function can_get_airport()
    {
        $airport = $this->getFirstAttributeOptionByName('Airport');

        $this->assertEquals($airport->id, $this->resort->airport->id);
    }

    /** @test */
    public function can_get_type()
    {
        $type = $this->getFirstAttributeOptionByName('Resort Type');

        $this->assertEquals($type->id, $this->resort->type->id);
    }

    private function getFirstAttributeOptionByName($attributeName)
    {
        return AttributeOption::whereAttributeId(
            Attribute::whereName($attributeName)->first()->id
        )->first();
    }

    /** @test */
    public function can_get_by_id()
    {
        $firstResort = Resort::first();
        $resort = Resort::find($firstResort->id);

        $this->assertGreaterThan(0, $resort->id);
        $this->assertEquals($resort->id, $this->resort->id);
    }

    /** @test */
    public function can_get_albums_and_photos()
    {
        $this->createResortProduct();
        $this->createProductAlbum();
        $this->createResortProductAttribute();

        $this->assertCount(1, $this->resort->albums);

        $photo = Photo::firstOrFactory(['album' => $this->resortAlbum->id]);

        $this->assertCount(1, $this->resort->photos);
    }

    /** @test */
    public function can_get_products()
    {
        $this->createResortProduct();
        $this->createResortProductAttribute();

        $products = $this->resort->products;
        $this->assertCount(1, $products);
        $this->assertInstanceOf(Product::class, $products->first());
//        dd($this->resort->attribute_option_id, Query::toSql($this->resort->products()));
    }

    /** @test */
    public function can_get_product_images()
    {
        $this->createResortProduct();
        $this->createResortProductAttribute();

        ProductImage::factory()->create(['show_in_gallery' => 1]);

        $images = $this->resort->images(true)->get();

        $this->assertCount(1, $images);
        $this->assertInstanceOf(Image::class, $images->first());

        $this->resortProduct->update(['status' => 0]);

        $images = $this->resort->images(true)->get();

        $this->assertCount(0, $images);
    }

    /** @test */
    public function can_get_specialties()
    {
        $this->createResortProduct();
        $this->createResortProductAttribute();
//        ProductSpecialty::firstOrFactory();
        $this->createSpecialtyProductAttribute();

        $specialties = $this->resort->specialties;
        $this->assertCount(3, $specialties);
        $this->assertInstanceOf(AttributeOption::class, $specialties->first());
    }
}
