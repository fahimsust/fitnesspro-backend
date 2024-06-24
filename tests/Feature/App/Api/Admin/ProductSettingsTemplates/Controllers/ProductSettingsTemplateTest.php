<?php

namespace Tests\Feature\App\Api\Admin\ProductSettingsTemplates\Controllers;

use App\Api\Admin\ProductSettingsTemplates\Requests\ProductSettingsTemplateRequest;
use Domain\Products\Models\Product\Settings\ProductSettingsTemplate;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductSettingsTemplateTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_product_setting_template()
    {
        ProductSettingsTemplate::factory(15)->create();

        $this->getJson(route('admin.product-settings-template.index'))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                ]
            ])->assertJsonCount(15);
    }

    /** @test */
    public function can_create_new_product_setting_template()
    {
        ProductSettingsTemplateRequest::fake();
        $this->postJson(route('admin.product-settings-template.store'))
            ->assertCreated()
            ->assertJsonStructure(['id', 'layout_id']);

        $this->assertDatabaseCount(ProductSettingsTemplate::Table(), 1);
    }
    /** @test */
    public function can_update_product_setting_template()
    {
        $productSettingsTemplate = ProductSettingsTemplate::factory()->create();
        ProductSettingsTemplateRequest::fake(['name' => 'test']);

        $this->putJson(route(
            'admin.product-settings-template.update',
            [$productSettingsTemplate]
        ))
            ->assertCreated();

        $this->assertEquals('test', $productSettingsTemplate->refresh()->name);
    }

    /** @test */
    public function can_delete_product_setting_template()
    {
        $productSettingsTemplate = ProductSettingsTemplate::factory(5)->create();

        $this->deleteJson(route('admin.product-settings-template.destroy', [$productSettingsTemplate->first()]))
            ->assertOk();

        $this->assertDatabaseCount(ProductSettingsTemplate::Table(), 4);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();
        ProductSettingsTemplate::factory(15)->create();
        $this->getJson(route('admin.product-settings-template.index'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
