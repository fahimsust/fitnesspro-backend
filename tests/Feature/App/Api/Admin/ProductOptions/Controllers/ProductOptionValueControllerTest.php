<?php

namespace Tests\Feature\App\Api\Admin\ProductOptions\Controllers;

use App\Api\Admin\ProductOptions\Requests\UpdateProductOptionValueRequest;
use App\Api\Admin\ProductOptions\Requests\CreateProductOptionValueRequest;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\ProductVariantOption;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductOptionValueControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_search_product_option_value_by_start_date_end_date()
    {
        $productOption = ProductOption::factory()->create();
        $dateNow = Carbon::now()->toDateString();
        $dateTwenty = Carbon::now()->addDays(20)->toDateString();
        $dateFifteen = Carbon::now()->addDays(15)->toDateString();
        $dateTen = Carbon::now()->addDays(10)->toDateString();
        $dateThirty = Carbon::now()->addDays(30)->toDateString();
        $dateTwo = Carbon::now()->addDays(2)->toDateString();
        $dateTwentyTwo = Carbon::now()->addDays(22)->toDateString();
        $dateTwentyOne = Carbon::now()->addDays(21)->toDateString();
        ProductOptionValue::factory()->create(['name' => 'test1', 'start_date' => $dateNow, 'end_date' => $dateTwenty]);
        ProductOptionValue::factory()->create(['name' => 'test1', 'start_date' => $dateFifteen, 'end_date' => $dateThirty]);
        ProductOptionValue::factory()->create(['name' => 'test1', 'start_date' => $dateTwenty, 'end_date' => $dateThirty]);
        ProductOptionValue::factory()->create(['name' => 'test1', 'start_date' => $dateTen, 'end_date' => $dateFifteen]);
        ProductOptionValue::factory()->create(['name' => 'test1', 'start_date' => $dateNow, 'end_date' => $dateTen]);
        ProductOptionValue::factory()->create(['name' => 'test1', 'start_date' => $dateTwenty, 'end_date' => $dateTwentyOne]);

        $this->getJson(
            route('admin.product-option-values.list', [$productOption, 'keyword' => 'test', 'start_date' => $dateTwo]),
        )->assertOk()
            ->assertJsonCount(2, 'data');

        $this->getJson(
            route('admin.product-option-values.list', [$productOption, 'keyword' => 'test', 'end_date' => $dateTen]),
        )->assertOk()
            ->assertJsonCount(3, 'data');

        $this->getJson(
            route('admin.product-option-values.list', [$productOption, 'keyword' => 'test', 'start_date' => $dateTen]),
        )->assertOk()
            ->assertJsonCount(3, 'data');

        $this->getJson(
            route('admin.product-option-values.list', [$productOption, 'keyword' => 'test', 'start_date' => $dateTen, 'end_date' => $dateTwentyTwo]),
        )->assertOk()
            ->assertJsonCount(6, 'data');

        $this->getJson(
            route('admin.product-option-values.list', [$productOption, 'keyword' => 'test', 'start_date' => $dateNow, 'end_date' => $dateTwo]),
        )->assertOk()
            ->assertJsonCount(2, 'data');
    }

    /** @test */
    public function can_search_product_option_value_by_product_option_id()
    {
        $productOption = ProductOption::factory()->create();
        ProductOptionValue::factory()->create(['name' => 'test1']);
        ProductOptionValue::factory()->create(['name' => 'test2']);
        ProductOptionValue::factory()->create(['name' => 'not_match']);

        $this->getJson(
            route('admin.product-option-values.list', [$productOption, 'keyword' => 'test']),

        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                    'display',
                    'rank'
                ]
            ]])
            ->assertJsonCount(2, 'data');
    }

    /** @test */
    public function can_get_all_the_option_value_by_product_option_id()
    {
        $productOptions = ProductOption::factory(2)->create();
        ProductOptionValue::factory(15)->create(['option_id' => $productOptions->first()->id]);
        ProductOptionValue::factory(5)->create(['option_id' => $productOptions[1]->id]);

        $this->getJson(route('admin.product-option-values.list', $productOptions->first()))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                    'display',
                    'rank'
                ]
            ]])
            ->assertJsonCount(15, 'data');
    }

    /** @test */
    public function can_create_new_product_option_value()
    {
        CreateProductOptionValueRequest::fake();
        $this->postJson(route('admin.product-option-value.store'))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(ProductOptionValue::Table(), 1);
    }

    /** @test */
    public function can_update_product_option_value()
    {
        $productOptionValue = ProductOptionValue::factory()->create();
        UpdateProductOptionValueRequest::fake(['name' => 'test']);

        $this->putJson(route('admin.product-option-value.update', [$productOptionValue]))
            ->assertCreated();

        $this->assertEquals('test', $productOptionValue->refresh()->name);
    }

    /** @test */
    public function can_delete_product_option_value()
    {
        $productOptionValue = ProductOptionValue::factory()->create();

        $this->deleteJson(route('admin.product-option-value.destroy', [$productOptionValue]))
            ->assertOk();

        $this->assertDatabaseCount(ProductOptionValue::Table(), 0);
    }

    /** @test */
    public function can_get_exception_for_product_exists()
    {
        $productOption = ProductOption::factory()->create();
        $productOptionValue = ProductOptionValue::factory()->create(['option_id' => $productOption->id]);
        ProductVariantOption::factory()->create(['option_id' => $productOptionValue->id]);

        $response = $this->deleteJson(route('admin.product-option-value.destroy', [$productOptionValue]))
            ->assertStatus(500);

        $this->assertStringContainsString('option value', $response['message']);
        $this->assertDatabaseCount(ProductOptionValue::Table(), 1);
    }


    /** @test */
    public function can_validate_request_and_return_errors()
    {
        CreateProductOptionValueRequest::fake(['display' => '']);
        $this->postJson(route('admin.product-option-value.store'))
            ->assertJsonValidationErrorFor('display')
            ->assertStatus(422);

        $this->assertDatabaseCount(ProductOptionValue::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        CreateProductOptionValueRequest::fake();
        $this->postJson(route('admin.product-option-value.store'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ProductOptionValue::Table(), 0);
    }
}
