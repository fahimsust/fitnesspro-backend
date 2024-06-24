<?php

namespace Tests\Feature\App\Api\Admin\Discounts\Controllers;

use App\Api\Admin\Discounts\Requests\DiscountLevelRequest;
use Domain\Discounts\Actions\Admin\CreateDiscountLevel;
use Domain\Discounts\Models\Level\DiscountLevel;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class DiscountLevelControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_discount_levels()
    {
        DiscountLevel::factory(5)->create();
        $this->getJson(route('admin.discount-level.index'))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                ]
            ])
            ->assertJsonCount(5);
    }

    /** @test */
    public function can_create_new_discount_level()
    {
        DiscountLevelRequest::fake();

        $this->postJson(route('admin.discount-level.store'))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(DiscountLevel::Table(), 1);
    }

    /** @test */
    public function can_update_discount_level()
    {
        $discountLevel = DiscountLevel::factory()->create();
        DiscountLevelRequest::fake(['name' => 'test']);

        $this->putJson(route('admin.discount-level.update', [$discountLevel]))
            ->assertCreated();

        $this->assertEquals('test', $discountLevel->refresh()->name);
    }
    /** @test */
    public function can_get_discount_level()
    {
        $discountLevel = DiscountLevel::factory()->create();
        $this->getJson(route('admin.discount-level.show', [$discountLevel]))
            ->assertOk()
            ->assertJsonStructure(['id', 'name']);
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $data = DiscountLevelRequest::factory()->create(['name' => '']);

        $this->postJson(route('admin.discount-level.store'), $data)
            ->assertJsonValidationErrorFor('name')
            ->assertStatus(422);

        $this->assertDatabaseCount(DiscountLevel::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(CreateDiscountLevel::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        DiscountLevelRequest::fake();

        $this->postJson(route('admin.discount-level.store'))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(DiscountLevel::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        DiscountLevelRequest::fake();

        $this->postJson(route('admin.discount-level.store'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(DiscountLevel::Table(), 0);
    }
}
