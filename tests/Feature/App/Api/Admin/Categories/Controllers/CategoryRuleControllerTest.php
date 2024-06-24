<?php

namespace Tests\Feature\App\Api\Admin\Categories\Controllers;

use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\Rule\CategoryRule;
use Illuminate\Support\Facades\Auth;
use Support\Enums\MatchAllAnyString;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CategoryRuleControllerTest extends ControllerTestCase
{
    public Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
        $this->category = Category::factory()->create();
    }

    /** @test */
    public function can_add_category_rule()
    {
        $this->postJson(
            route('admin.category.rule.store', $this->category),
            ["match_type" => MatchAllAnyString::ANY]
        )
            ->assertCreated()
            ->assertJsonStructure(['match_type', 'category_id']);

        $this->assertDatabaseCount(CategoryRule::Table(), 1);
    }
    /** @test */
    public function can_update_category_rule()
    {
        $categoryRule = CategoryRule::factory()->create(['match_type' => MatchAllAnyString::ANY]);

        $this->putJson(
            route('admin.category.rule.update', [$this->category, $categoryRule->id]),
            ['match_type' => MatchAllAnyString::ALL]
        )
            ->assertCreated();

        $this->assertEquals(MatchAllAnyString::ALL, $categoryRule->refresh()->match_type);
    }

    /** @test */
    public function can_delete_category_rule()
    {
        $categoryRule = CategoryRule::factory()->create(['match_type' => MatchAllAnyString::ANY]);

        $this->deleteJson(
            route('admin.category.rule.destroy', [$this->category, $categoryRule->id]),
        )->assertOk();

        $this->assertDatabaseCount(CategoryRule::Table(), 0);
    }

    /** @test */
    public function can_get_category_rule()
    {
        CategoryRule::factory(10)->create();
        $this->getJson(route('admin.category.rule.index', $this->category))
            ->assertOk()
            ->assertJsonStructure(["*" => ['id', 'match_type']])
            ->assertJsonCount(10);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.category.rule.store', $this->category), ["match_type" => ''])
            ->assertJsonValidationErrorFor('match_type')
            ->assertStatus(422);

        $this->assertDatabaseCount(CategoryRule::Table(), 0);
    }

    /** @test */
    public function auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.category.rule.store', $this->category), ["match_type" => MatchAllAnyString::ANY])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(CategoryRule::Table(), 0);
    }
}
