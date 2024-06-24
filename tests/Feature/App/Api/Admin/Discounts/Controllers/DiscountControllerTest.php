<?php

namespace Tests\Feature\App\Api\Admin\Discounts\Controllers;

use App\Api\Admin\Discounts\Requests\DiscountRequest;
use Domain\Discounts\Actions\Admin\CreateDiscount;
use Domain\Discounts\Models\Discount;
use Illuminate\Support\Facades\Auth;
use Support\Enums\MatchAllAnyInt;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class DiscountControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_discount()
    {
        DiscountRequest::fake();

        $this->postJson(route('admin.discount.store'))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(Discount::Table(), 1);
    }

    /** @test */
    public function can_update_discount()
    {
        $discount = Discount::factory()->create();
        DiscountRequest::fake(['name' => 'test']);

        $this->putJson(route('admin.discount.update', [$discount]))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals('test', $discount->refresh()->name);
    }
    /** @test */
    public function can_update_discount_match_rule_all_any()
    {
        $discount = Discount::factory()->create();
        $this->putJson(route('admin.discount-match-rule.update', [$discount]), ['match_anyall' => true])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals(MatchAllAnyInt::ANY, $discount->refresh()->match_anyall);
    }
    /** @test */
    public function can_update_discount_status()
    {
        $discount = Discount::factory()->create(['status' => false]);

        $this->postJson(route('admin.discount.status', [$discount]), ['status' => true])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertTrue($discount->refresh()->status);
    }
    /** @test */
    public function can_get_discount()
    {
        $discount = Discount::factory()->create();
        $this->getJson(route('admin.discount.show', [$discount]))
            ->assertOk()
            ->assertJsonStructure(['id', 'name', 'display']);
    }
    /** @test */

    public function can_search_discount()
    {
        Discount::factory()->create(['name' => 'test1', 'status' => true]);
        Discount::factory()->create(['name' => 'test2', 'status' => false]);
        Discount::factory()->create(['name' => 'not_match']);

        $this->getJson(
            route('admin.discount.index', ["per_page" => 5, "page" => 1, 'keyword' => 'test', 'status' => true]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                    'display'
                ]
            ]])->assertJsonCount(1, 'data');
    }

    /** @test */
    public function can_delete_discount()
    {
        $discounts = Discount::factory(5)->create();

        $this->deleteJson(route('admin.discount.destroy', [$discounts->first()]))
            ->assertOk();

        $this->assertEquals(4, Discount::count());
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $data = DiscountRequest::factory()->create(['name' => '']);

        $this->postJson(route('admin.discount.store'), $data)
            ->assertJsonValidationErrorFor('name')
            ->assertStatus(422);

        $this->assertDatabaseCount(Discount::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(CreateDiscount::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        DiscountRequest::fake();

        $this->postJson(route('admin.discount.store'))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(Discount::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        DiscountRequest::fake();

        $this->postJson(route('admin.discount.store'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(Discount::Table(), 0);
    }
}
