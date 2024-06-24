<?php

namespace Tests\Feature\Domain\Resorts;

use Database\Seeders\CountryRegionSeeder;
use Database\Seeders\CountrySeeder;
use Database\Seeders\StateSeeder;
use Domain\AdminUsers\Models\User;
use Domain\Photos\Models\PhotoAlbum;
use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAttribute;
use Domain\Resorts\Models\Resort;

abstract class ResortTestCase extends \Tests\TestCase
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    protected Resort $resort;

    protected Product $resortProduct;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    protected PhotoAlbum $resortAlbum;

    protected ProductAttribute $productAttribute;

    protected function createResort()
    {
        $this->seed([
            CountrySeeder::class,
            CountryRegionSeeder::class,
            StateSeeder::class,
        ]);

        $this->resort = Resort::factory([
            'logo' => 'https://fitnessprotravel.com/files/24891_hedologo.jpg',
            'description' => //"\xB1\x31" .
                htmlspecialchars('<p>Test Resort</p>').' and remove space &nbsp;.',
            'fpt_manager_id' => User::firstOrFactory(),
        ])->create();

        //was causing errors
//        $this->seed([
//            ResortSeeder::class
//        ]);
    }

    protected function createResortProduct()
    {
        $this->resortProduct = Product::firstOrFactory();
    }

    protected function createProductAlbum()
    {
        $this->resortAlbum = PhotoAlbum::factory()->create([
            'type_id' => $this->resortProduct->id,
            'type' => 2,
        ]);
    }

    protected function createResortProductAttribute()
    {
        $this->productAttribute = ProductAttribute::create([
            'product_id' => $this->resortProduct->id,
            'option_id' => $this->resort->id,
        ]);
    }

    protected function createSpecialtyProductAttribute()
    {
        Attribute::find(config('trips.specialty_attribute_id'))?->delete();

        $attribute = Attribute::factory()->create([
            'id' => config('trips.specialty_attribute_id'),
            'name' => 'Specialty',
        ]);

        AttributeOption::factory()->count(3)
            ->create([
                'attribute_id' => $attribute->id,
            ])
            ->each(
                fn (AttributeOption $specialtyOption) => ProductAttribute::create([
                    'product_id' => $this->resortProduct->id,
                    'option_id' => $specialtyOption->id,
                ])
            );
    }
}
