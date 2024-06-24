<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Perform;

use Domain\Locales\Models\Language;
use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\BulkEdit\BulkEditActivity;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionTranslation;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Option\ProductOptionValueTranslation;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductTranslation;
use Illuminate\Database\Eloquent\Collection;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class PerformKeywordTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_get_option()
    {
        $this->getJson(route('admin.bulk-edit-perform.index'))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                ]
            ])
            ->assertJsonCount(count(ActionList::cases()));
    }

    /** @test */
    public function can_change_product_title()
    {
        $products = Product::factory(10)->create(['title' => 'testing title 1001 will be change']);
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::REPLACE_SUBTEXT_WITH_TEXT,
                'column' => 'p.title',
                'keyword' => '1001 will be change',
                'replace' => '2002 updated',
                'ids' => $products->pluck('id')->toArray()
            ]
        )
            ->assertOk();
        $this->assertEquals('testing title 2002 updated', Product::first()->title);
        $this->assertDatabaseCount(BulkEditActivity::Table(), 1);
    }
     /** @test */
     public function can_change_product_title_translation()
     {
         $language = Language::factory()->create();
         $products = Product::factory(10)->create(['title' => 'testing title 1001 will be change']);
         $productIds = $products->map(function ($product) use ($language) {
            $translation = ProductTranslation::factory()->create([
                'product_id' => $product->id,
                'title' => 'testing title 1001 will be change',
                'language_id' => $language->id
            ]);
            return $translation->product_id;
        })->toArray();

         $this->postJson(
             route('admin.bulk-edit-perform.store'),
             [
                 'action_name' => ActionList::REPLACE_SUBTEXT_WITH_TEXT,
                 'column' => 'p.title',
                 'keyword' => '1001 will be change',
                 'replace' => '2002 updated',
                 'language_id'=>$language->id,
                 'ids' => $productIds
             ]
         )
             ->assertOk();
         $this->assertNotEquals('testing title 2002 updated', Product::first()->title);
         $this->assertEquals('testing title 2002 updated', ProductTranslation::first()->title);
         $this->assertDatabaseCount(BulkEditActivity::Table(), 1);
     }
    /** @test */
    public function can_change_product_summary()
    {
        $products = Product::factory(2)->create();
        ProductDetail::factory()->create(['summary' => 'testing title 1001 will be change']);
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::REPLACE_SUBTEXT_WITH_TEXT,
                'column' => 'pd.summary',
                'keyword' => '1001 will be change',
                'replace' => '2002 updated',
                'ids' => $products->pluck('id')->toArray()
            ]
        )
            ->assertOk();
        $this->assertEquals('testing title 2002 updated', ProductDetail::first()->summary);
        $this->assertDatabaseCount(BulkEditActivity::Table(), 1);
    }

    /** @test */
    public function can_change_product_summary_translation()
    {
        $language = Language::factory()->create();
        $products = Product::factory(10)->create();
        ProductDetail::factory()->create(['summary' => 'testing title 1001 will be change']);
        $productIds = $products->map(function ($product) use ($language) {
           $translation = ProductTranslation::factory()->create([
               'product_id' => $product->id,
               'summary' => 'testing title 1001 will be change',
               'language_id' => $language->id
           ]);
           return $translation->product_id;
       })->toArray();

        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::REPLACE_SUBTEXT_WITH_TEXT,
                'column' => 'pd.summary',
                'keyword' => '1001 will be change',
                'replace' => '2002 updated',
                'language_id'=>$language->id,
                'ids' => $productIds
            ]
        )
            ->assertOk();
        $this->assertNotEquals('testing title 2002 updated', ProductDetail::first()->summary);
        $this->assertEquals('testing title 2002 updated', ProductTranslation::first()->summary);
        $this->assertDatabaseCount(BulkEditActivity::Table(), 1);
    }

    /** @test */
    public function can_change_product_option()
    {
        $products = Product::factory(2)->create();
        ProductOption::factory()->create(['name' => 'testing title 1001 will be change']);
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::REPLACE_SUBTEXT_WITH_TEXT,
                'column' => 'po.name',
                'keyword' => '1001 will be change',
                'replace' => '2002 updated',
                'ids' => $products->pluck('id')->toArray()
            ]
        )
            ->assertOk();
        $this->assertEquals('testing title 2002 updated', ProductOption::first()->name);
        $this->assertDatabaseCount(BulkEditActivity::Table(), 1);
    }
     /** @test */
     public function can_change_product_option_translation()
     {
         $language = Language::factory()->create();
         $products = Product::factory(2)->create();
         $productOption = ProductOption::factory()->create(['name' => 'testing title 1001 will be change']);
         ProductOptionTranslation::factory()->create([
            'product_option_id'=>$productOption->id,
            'language_id'=>$language->id,
            'name'=>'testing title 1001 will be change'
         ]);
         $this->postJson(
             route('admin.bulk-edit-perform.store'),
             [
                 'action_name' => ActionList::REPLACE_SUBTEXT_WITH_TEXT,
                 'column' => 'po.name',
                 'keyword' => '1001 will be change',
                 'replace' => '2002 updated',
                 'language_id'=>$language->id,
                 'ids' => $products->pluck('id')->toArray()
             ]
         )
             ->assertOk();
         $this->assertNotEquals('testing title 2002 updated', ProductOption::first()->name);
         $this->assertEquals('testing title 2002 updated', ProductOptionTranslation::first()->name);
         $this->assertDatabaseCount(BulkEditActivity::Table(), 1);
     }
    /** @test */
    public function can_change_product_option_value()
    {
        $products = Product::factory(2)->create();
        ProductOptionValue::factory()->create(['name' => 'testing title 1001 will be change']);
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::REPLACE_SUBTEXT_WITH_TEXT,
                'column' => 'pov.name',
                'keyword' => '1001 will be change',
                'replace' => '2002 updated',
                'ids' => $products->pluck('id')->toArray()
            ]
        )
            ->assertOk();
        $this->assertEquals('testing title 2002 updated', ProductOptionValue::first()->name);
        $this->assertDatabaseCount(BulkEditActivity::Table(), 1);
    }
    /** @test */
    public function can_change_product_option_value_translation()
    {
        $language = Language::factory()->create();
        $products = Product::factory(2)->create();
        $productOptionValue = ProductOptionValue::factory()->create(['name' => 'testing title 1001 will be change']);
        ProductOptionValueTranslation::factory()->create([
            'product_option_value_id'=>$productOptionValue->id,
            'language_id'=>$language->id,
            'name'=>'testing title 1001 will be change'
         ]);
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::REPLACE_SUBTEXT_WITH_TEXT,
                'column' => 'pov.name',
                'keyword' => '1001 will be change',
                'replace' => '2002 updated',
                'language_id'=>$language->id,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
            ->assertOk();
        $this->assertEquals('testing title 2002 updated', ProductOptionValueTranslation::first()->name);
        $this->assertNotEquals('testing title 2002 updated', ProductOptionValue::first()->name);
        $this->assertDatabaseCount(BulkEditActivity::Table(), 1);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $products = Product::factory(10)->create(['title' => 'testing title 1001 will be change']);
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::REPLACE_SUBTEXT_WITH_TEXT,
                'column' => 'p.title',
                'replace' => '2002 updated',
                'ids' => $products->pluck('id')->toArray()
            ]
        )
        ->assertJsonValidationErrorFor('keyword')
        ->assertStatus(422);
    }
}
