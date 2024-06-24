<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use Domain\Distributors\Models\Distributor;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Products\Models\Product\ProductVariantOption;
use Domain\Products\Models\Product\Settings\ProductSiteSettings;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductVariantControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_product_variant()
    {
        $distributer = Distributor::factory()->create();
        $productOptionValue = ProductOptionValue::factory(4)->create();
        $distributer2 = Distributor::factory()->create();
        $product = Product::factory()->create();
        $childProducts = Product::factory(10)->create(['parent_product' => $product->id, 'default_distributor_id' => $distributer->id, 'combined_stock_qty' => 3]);
        $childProducts2 = Product::factory(10)->create(['parent_product' => $product->id, 'default_distributor_id' => $distributer2->id, 'combined_stock_qty' => 2]);
        foreach ($productOptionValue as $optionValue) {
            foreach ($childProducts as $childProduct) {
                ProductVariantOption::factory()->create(['product_id' => $childProduct->id, 'option_id' => $optionValue->id]);
            }
            foreach ($childProducts2 as $childProduct) {
                ProductVariantOption::factory()->create(['product_id' => $childProduct->id, 'option_id' => $optionValue->id]);
            }
        }

        $data = $this->getJson(route('admin.product.product-variant.index', [$product]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'sku',
                    'combined_stock_qty',
                    'status',
                    'full_name',
                    'distributor_name'
                ]
            ]]);


        $this->assertEquals(20, $data['total']);
        $this->getJson(route('admin.product.variant-summary', [$product]))
            ->assertJson([
                'total' => 20,
                'total_stock_qty' => 50.00
            ])
            ->assertOk();
    }

    /** @test */
    public function can_delete_product_variant()
    {
        $product = Product::factory()->create();
        $productDetails = ProductDetail::factory()->create(['product_id' => $product->id]);
        $productPricing = ProductPricing::factory()->create(['product_id' => $product->id]);
        $productSiteSetting = ProductSiteSettings::factory()->create(['product_id' => $product->id, 'site_id' => null]);
        $childProduct = Product::factory()->create(['parent_product' => $product->id]);
        ProductVariantOption::factory()->create(['product_id' => $childProduct->id]);
        $this->deleteJson(route('admin.product.product-variant.destroy', [$childProduct, $product->id]))
            ->assertOk();

        $childProductRefresh = $childProduct->refresh();
        $this->assertNull($childProductRefresh->parent_product);
        $this->assertEquals(
            $productDetails->summary,
            $childProductRefresh->details->summary
        );

        $this->assertEquals(
            $productPricing->price_reg,
            $childProductRefresh->pricing->first()->price_reg
        );

        $this->assertEquals(
            $productSiteSetting->settings_template_id,
            $childProductRefresh->siteSettings->first()->settings_template_id
        );
    }
}
