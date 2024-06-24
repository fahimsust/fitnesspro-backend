<?php

namespace Tests\Feature\App\Api\Admin\OrderingRules\Controllers;

use App\Api\Admin\OrderingRules\Requests\OrderingRuleTranslationRequest;
use Domain\Locales\Models\Language;
use Domain\Products\Models\OrderingRules\OrderingRule;
use Domain\Products\Models\OrderingRules\OrderingRuleTranslation;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class OrderingRuleTranslationControllerTest extends ControllerTestCase
{
    private OrderingRule $orderingRule;
    private Language $language;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->orderingRule = OrderingRule::factory()->create();
        $this->language = Language::factory()->create();
    }

    /** @test */
    public function can_create_new_ordering_rule_translation()
    {
        OrderingRuleTranslationRequest::fake();
        $this->putJson(route('admin.ordering-rule.translation.update',[$this->orderingRule,$this->language->id]))
            ->assertCreated()
            ->assertJsonStructure(['id','name']);

        $this->assertDatabaseCount(OrderingRuleTranslation::Table(), 1);
    }

    /** @test */
    public function can_update_ordering_rule_translation()
    {
        OrderingRuleTranslation::factory()->create();
        OrderingRuleTranslationRequest::fake(['name' => 'test']);

        $this->putJson(route('admin.ordering-rule.translation.update', [$this->orderingRule,$this->language->id]))
            ->assertCreated();

        $this->assertDatabaseHas(OrderingRuleTranslation::Table(),['name'=>'test']);
    }
     /** @test */
     public function can_get_ordering_rule_translation()
     {
        OrderingRuleTranslation::factory()->create();
        $this->getJson(route('admin.ordering-rule.translation.show', [$this->orderingRule,$this->language->id]))
             ->assertOk()
             ->assertJsonStructure(
                 [
                     'id',
                 ]
             );
     }


    /** @test */
    public function can_validate_request_and_return_errors()
    {
        OrderingRuleTranslationRequest::fake(['name' => 1]);

        $this->putJson(route('admin.ordering-rule.translation.update',[$this->orderingRule,$this->language->id]))
            ->assertJsonValidationErrorFor('name')
            ->assertStatus(422);

        $this->assertDatabaseCount(OrderingRuleTranslation::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        OrderingRuleTranslationRequest::fake();

        $this->putJson(route('admin.ordering-rule.translation.update',[$this->orderingRule,$this->language->id]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(OrderingRuleTranslation::Table(), 0);
    }
}
