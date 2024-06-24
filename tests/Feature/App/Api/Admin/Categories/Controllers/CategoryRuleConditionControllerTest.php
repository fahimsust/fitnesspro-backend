<?php

namespace Tests\Feature\App\Api\Admin\Categories\Controllers;

use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Attribute\AttributeSet;
use Domain\Products\Models\Category\Rule\CategoryRule;
use Domain\Products\Models\Category\Rule\CategoryRuleAttribute;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CategoryRuleConditionControllerTest extends ControllerTestCase
{
    public CategoryRule $categoryRule;
    public AttributeOption $attributeOption;
    public AttributeSet $attributeSet;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
        $this->categoryRule = CategoryRule::factory()->create();
        $this->attributeOption = AttributeOption::factory()->create();
        $this->attributeSet = AttributeSet::factory()->create();
    }

    /** @test */
    public function can_add_category_rule()
    {
        $response = $this->postJson(
            route('admin.category-rule.condition.store', $this->categoryRule),
            [
                "matches" => true,
                "value_id" => $this->attributeOption->id,
                'set_id' => $this->attributeSet->id,
            ]
        )
            ->assertCreated()
            ->assertJsonStructure(['matches', 'value_id', 'rule_id']);

        $this->assertDatabaseCount(CategoryRuleAttribute::Table(), 1);
    }

    /** @test */
    public function can_delete_category_rule()
    {
        $categoryRuleAttribute = CategoryRuleAttribute::factory()->create();

        $this->deleteJson(
            route('admin.category-rule.condition.destroy', [$this->categoryRule, $categoryRuleAttribute->id]),
        )->assertOk();

        $this->assertDatabaseCount(CategoryRuleAttribute::Table(), 0);
    }

    /** @test */
    public function can_get_category_rule()
    {
        CategoryRuleAttribute::factory(10)->create();
        $this->getJson(route('admin.category-rule.condition.index', $this->categoryRule))
            ->assertOk()
            ->assertJsonStructure(
                [
                    "*" => [
                        'id',
                        'matches',
                        'attribute_option' => [
                            'display',
                            'attribute' => ['name']
                        ]
                    ]
                ]
            )
            ->assertJsonCount(10);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(
            route('admin.category-rule.condition.store', $this->categoryRule),
            [
                "matches" => true,
                "value_id" => 'error',
            ]
        )
            ->assertJsonValidationErrorFor('value_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(CategoryRuleAttribute::Table(), 0);
    }

    /** @test */
    public function auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(
            route('admin.category-rule.condition.store', $this->categoryRule),
            [
                "matches" => true,
                "value_id" => $this->attributeOption->id,
            ]
        )
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(CategoryRuleAttribute::Table(), 0);
    }
}
