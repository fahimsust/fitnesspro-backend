<?php

namespace Tests\Feature\App\Api\Admin\ProductOptions\Controllers;

use App\Api\Admin\ProductOptions\Requests\CreateDateOptionValuesRequest;
use Carbon\Carbon;
use Domain\Products\Actions\ProductOptions\CreateDateOptionValues;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CreateDateOptionValuesControllersTest extends ControllerTestCase
{
    private ProductOption $productOption;
    protected function setUp(): void
    {
        parent::setUp();
        $this->productOption = ProductOption::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_four_product_option_value()
    {
        CreateDateOptionValuesRequest::fake();
        $response = $this->postJson(route('admin.product-option-values.dates',$this->productOption))
            ->assertCreated();
        $expected = Carbon::now()->addDays(6)->toDateString();
        $actual = Carbon::parse($response[0]['end_date'])->toDateString();
        $this->assertEquals($expected,$actual);

        $expected = Carbon::now()->toDateString();
        $actual = Carbon::parse($response[0]['start_date'])->toDateString();
        $this->assertEquals($expected,$actual);

        $this->assertEquals($this->productOption->id,$response[0]['option_id']);

        $expected = Carbon::now()->addDays(13)->toDateString();
        $actual = Carbon::parse($response[1]['end_date'])->toDateString();
        $this->assertEquals($expected,$actual);

        $expected = Carbon::now()->addDays(7)->toDateString();
        $actual = Carbon::parse($response[1]['start_date'])->toDateString();
        $this->assertEquals($expected,$actual);

        $this->assertEquals($this->productOption->id,$response[1]['option_id']);

        $expected = Carbon::now()->addDays(20)->toDateString();
        $actual = Carbon::parse($response[2]['end_date'])->toDateString();
        $this->assertEquals($expected,$actual);

        $expected = Carbon::now()->addDays(14)->toDateString();
        $actual = Carbon::parse($response[2]['start_date'])->toDateString();
        $this->assertEquals($expected,$actual);

        $this->assertEquals($this->productOption->id,$response[1]['option_id']);


        $expected = Carbon::now()->addDays(27)->toDateString();
        $actual = Carbon::parse($response[3]['end_date'])->toDateString();
        $this->assertEquals($expected,$actual);

        $expected = Carbon::now()->addDays(21)->toDateString();
        $actual = Carbon::parse($response[3]['start_date'])->toDateString();
        $this->assertEquals($expected,$actual);

        $this->assertEquals($this->productOption->id,$response[3]['option_id']);

        $this->assertDatabaseCount(ProductOptionValue::Table(), 4);
    }

    /** @test */
    public function can_create_three_product_option_value()
    {
        CreateDateOptionValuesRequest::fake(['days_duration' => 8]);
        $this->postJson(route('admin.product-option-values.dates',$this->productOption))
            ->assertCreated();

        $this->assertDatabaseCount(ProductOptionValue::Table(), 3);
    }

    /** @test */
    public function can_create_two_product_option_value_checking_skip_days()
    {
        CreateDateOptionValuesRequest::fake(['days_skip_between' => 8]);
        $this->postJson(route('admin.product-option-values.dates',$this->productOption))
            ->assertCreated();

        $this->assertDatabaseCount(ProductOptionValue::Table(), 2);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        CreateDateOptionValuesRequest::fake(['days_duration' => 0]);
        $this->postJson(route('admin.product-option-values.dates',$this->productOption))
            ->assertJsonValidationErrorFor('days_duration')
            ->assertStatus(422);

        $this->assertDatabaseCount(ProductOptionValue::Table(), 0);
    }

    /** @test */
    public function can_validate_request_and_return_errors_for_duration_is_greater_then_range()
    {
        CreateDateOptionValuesRequest::fake(['days_duration' => 35]);
        $this->postJson(route('admin.product-option-values.dates',$this->productOption))
            ->assertJsonValidationErrorFor('days_duration')
            ->assertStatus(422);

        $this->assertDatabaseCount(ProductOptionValue::Table(), 0);
    }

    /** @test */
    public function can_validate_request_and_return_errors_skip_duration_less_then_one()
    {
        CreateDateOptionValuesRequest::fake(['days_duration' => 1,'days_skip_between'=>-1]);
        $this->postJson(route('admin.product-option-values.dates',$this->productOption))
            ->assertJsonValidationErrorFor('days_duration')
            ->assertStatus(422);

        $this->assertDatabaseCount(ProductOptionValue::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(CreateDateOptionValues::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        CreateDateOptionValuesRequest::fake();

        $this->postJson(route('admin.product-option-values.dates',$this->productOption))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(ProductOptionValue::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        CreateDateOptionValuesRequest::fake();

        $this->postJson(route('admin.product-option-values.dates',$this->productOption))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ProductOptionValue::Table(), 0);
    }

}
